<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\MenuItem;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;

class MenuBoard extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public $mainCategories;
    public $selectedMainCategoryId;
    public $categories;
    public $directItems;
    public $activeLocale = 'tr';
    public $search = '';
    public $selectedSubCategoryId = 'general';

    public function mount()
    {
        $this->mainCategories = Category::whereNull('parent_id')
            ->orderBy('order_column')
            ->get();
        
        $this->selectedMainCategoryId = $this->mainCategories->first()?->id;
        $this->loadCategories();
        $this->selectedSubCategoryId = $this->directItems->count() > 0 ? 'general' : ($this->categories->first()?->id ?? 'general');
    }

    public function loadCategories()
    {
        if ($this->selectedMainCategoryId) {
            $this->categories = Category::where('parent_id', $this->selectedMainCategoryId)
                ->with(['menuItems' => function($q) {
                    $q->orderBy('order_column');
                    if (!empty($this->search)) {
                        $q->where(function($query) {
                            $query->where('name->' . $this->activeLocale, 'like', '%' . $this->search . '%')
                                  ->orWhere('description->' . $this->activeLocale, 'like', '%' . $this->search . '%');
                        });
                    }
                }])
                ->orderBy('order_column')
                ->get();
                
            $this->directItems = MenuItem::where('category_id', $this->selectedMainCategoryId)
                ->orderBy('order_column')
                ->when(!empty($this->search), function($q) {
                    $q->where(function($query) {
                        $query->where('name->' . $this->activeLocale, 'like', '%' . $this->search . '%')
                              ->orWhere('description->' . $this->activeLocale, 'like', '%' . $this->search . '%');
                    });
                })
                ->get();
        } else {
            $this->categories = collect();
            $this->directItems = collect();
        }
    }

    public function selectMainCategory($id)
    {
        $this->selectedMainCategoryId = $id;
        $this->loadCategories();
        $this->selectedSubCategoryId = $this->directItems->count() > 0 ? 'general' : ($this->categories->first()?->id ?? 'general');
    }

    public function updatedActiveLocale()
    {
        $this->loadCategories();
    }

    public function updatedSearch()
    {
        $this->loadCategories();
    }

    public function updateItemOrder($items)
    {
        foreach ($items as $item) {
            if (isset($item['value']) && $item['value']) {
                MenuItem::where('id', $item['value'])->update([
                    'order_column' => $item['order'],
                    'category_id' => $item['category_id']
                ]);
            }
        }

        Notification::make()
            ->title('Sıralama güncellendi')
            ->success()
            ->send();
            
        $this->loadCategories();
    }

    public function updateCategoryOrder($categories)
    {
        foreach ($categories as $cat) {
            if (isset($cat['value']) && $cat['value']) {
                Category::where('id', $cat['value'])->update([
                    'order_column' => $cat['order']
                ]);
            }
        }

        Notification::make()
            ->title('Kategori sıralaması güncellendi')
            ->success()
            ->send();

        $this->loadCategories();
    }

    public function updateMainCategoryOrder($categories)
    {
        foreach ($categories as $cat) {
            if (isset($cat['value']) && $cat['value']) {
                Category::where('id', $cat['value'])->update([
                    'order_column' => $cat['order']
                ]);
            }
        }

        Notification::make()
            ->title('Üst kategori sıralaması güncellendi')
            ->success()
            ->send();

        $this->mainCategories = Category::whereNull('parent_id')
            ->orderBy('order_column')
            ->get();

        $this->loadCategories();
    }

    public function editItemAction(): Action
    {
        return Action::make('editItem')
            ->form([
                Tabs::make('Item Form')
                    ->tabs([
                        Tabs\Tab::make('tr' === $this->activeLocale ? 'Temel Bilgiler' : 'Basic Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('tr' === $this->activeLocale ? 'Ürün Adı' : 'Product Name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, \Filament\Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                        TextInput::make('price')
                                            ->label('tr' === $this->activeLocale ? 'Fiyat' : 'Price')
                                            ->numeric()
                                            ->prefix('₺')
                                            ->required(),
                                    ]),
                                Textarea::make('description')
                                    ->label('tr' === $this->activeLocale ? 'Açıklama / Menü Detayı' : 'Description / Menu Details')
                                    ->rows(3)
                                    ->placeholder('tr' === $this->activeLocale ? 'Müşterilerinize ürünü tanıtın...' : 'Introduce the product to your customers...'),
                                
                                Grid::make(2)
                                    ->schema([
                                        Select::make('category_id')
                                            ->label('tr' === $this->activeLocale ? 'Kategori' : 'Category')
                                            ->options(function() {
                                                $mainCat = Category::find($this->selectedMainCategoryId);
                                                $options = [];
                                                if ($mainCat) {
                                                    $options[$mainCat->id] = 'Genel Ürünler (' . $mainCat->getTranslation('name', $this->activeLocale) . ')';
                                                }
                                                $subcats = Category::where('parent_id', $this->selectedMainCategoryId)->get();
                                                foreach ($subcats as $sub) {
                                                    $options[$sub->id] = $sub->getTranslation('name', $this->activeLocale);
                                                }
                                                return $options;
                                            })
                                            ->required(),
                                        TextInput::make('allergen_info')
                                            ->label('tr' === $this->activeLocale ? 'Alerjen Bilgisi' : 'Allergen Info')
                                            ->placeholder('tr' === $this->activeLocale ? 'Örn: Kuruyemiş, Süt, Glüten' : 'e.g. Nuts, Dairy, Gluten'),
                                    ]),
                                
                                Grid::make(4)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('tr' === $this->activeLocale ? 'Sitede Aktif' : 'Active on Site'),
                                        Toggle::make('is_featured')
                                            ->label('tr' === $this->activeLocale ? 'Öne Çıkan' : 'Featured Item'),
                                        Toggle::make('is_vegan')
                                            ->label('tr' === $this->activeLocale ? '🌱 Vegan' : '🌱 Vegan'),
                                        Toggle::make('is_vegetarian')
                                            ->label('tr' === $this->activeLocale ? '🥦 Vejetaryen' : '🥦 Vegetarian'),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-50/50 dark:bg-gray-800/30 p-4 rounded-xl border border-gray-150 dark:border-gray-800']),
                                
                                Grid::make(2)
                                    ->schema([
                                        Toggle::make('contains_alcohol')
                                            ->label('tr' === $this->activeLocale ? '🍷 Alkol İçerir' : '🍷 Contains Alcohol'),
                                        TextInput::make('calories')
                                            ->label('tr' === $this->activeLocale ? '🔥 Kalori (kcal)' : '🔥 Calories (kcal)')
                                            ->numeric()
                                            ->placeholder('Örn: 250'),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-50/30 dark:bg-gray-800/20 p-4 rounded-xl border border-gray-150/80 dark:border-gray-800/80 mt-2']),
                            ]),
                        Tabs\Tab::make('tr' === $this->activeLocale ? 'Görsel & Ek Bilgiler' : 'Media & Extras')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('tr' === $this->activeLocale ? 'Ürün Görseli' : 'Product Image')
                                    ->image()
                                    ->directory('menu-items')
                                    ->disk('public')
                                    ->imageEditor(),
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->helperText('tr' === $this->activeLocale ? 'URL uzantısı (Otomatik üretilir)' : 'URL slug (Auto-generated)'),
                                TextInput::make('likes_count')
                                    ->label('tr' === $this->activeLocale ? 'Beğeni Sayısı' : 'Likes Count')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ])
            ->fillForm(function (array $arguments) {
                $item = MenuItem::find($arguments['id']);
                return [
                    'category_id' => $item->category_id,
                    'name' => $item->getTranslation('name', $this->activeLocale),
                    'slug' => $item->getTranslation('slug', $this->activeLocale),
                    'price' => $item->price,
                    'description' => $item->getTranslation('description', $this->activeLocale),
                    'image' => $item->image,
                    'is_active' => $item->is_active,
                    'is_featured' => $item->is_featured,
                    'is_vegan' => $item->is_vegan,
                    'is_vegetarian' => $item->is_vegetarian ?? false,
                    'contains_alcohol' => $item->contains_alcohol ?? false,
                    'calories' => $item->calories,
                    'allergen_info' => $item->getTranslation('allergen_info', $this->activeLocale),
                    'likes_count' => $item->likes_count ?? 0,
                ];
            })
            ->action(function (array $data, array $arguments): void {
                $item = MenuItem::find($arguments['id']);
                if ($item) {
                    $item->category_id = $data['category_id'];
                    $item->setTranslation('name', $this->activeLocale, $data['name']);
                    $item->setTranslation('slug', $this->activeLocale, $data['slug']);
                    $item->setTranslation('description', $this->activeLocale, $data['description']);
                    if (isset($data['allergen_info'])) {
                        $item->setTranslation('allergen_info', $this->activeLocale, $data['allergen_info']);
                    } else {
                        $item->setTranslation('allergen_info', $this->activeLocale, null);
                    }
                    $item->price = $data['price'];
                    $item->image = $data['image'];
                    $item->is_active = $data['is_active'];
                    $item->is_featured = $data['is_featured'];
                    $item->is_vegan = $data['is_vegan'];
                    $item->is_vegetarian = $data['is_vegetarian'];
                    $item->contains_alcohol = $data['contains_alcohol'];
                    $item->calories = $data['calories'];
                    $item->likes_count = $data['likes_count'] ?? 0;
                    $item->save();

                    Notification::make()
                        ->title('Ürün güncellendi')
                        ->success()
                        ->send();
                }
                $this->loadCategories();
            })
            ->extraModalActions([
                Action::make('delete')
                    ->label('Sil / Delete')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (array $arguments): void {
                        $item = MenuItem::find($arguments['id']);
                        if ($item) {
                            $item->delete();
                            Notification::make()
                                ->title('Ürün silindi')
                                ->success()
                                ->send();
                        }
                        $this->loadCategories();
                    })
            ]);
    }

    public function editCategoryAction(): Action
    {
        return Action::make('editCategory')
            ->form([
                TextInput::make('name')
                    ->label('Category Name (' . strtoupper($this->activeLocale) . ')')
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug (' . strtoupper($this->activeLocale) . ')')
                    ->required(),
                Textarea::make('description')
                    ->label('Description (' . strtoupper($this->activeLocale) . ')')
                    ->rows(2),
                FileUpload::make('image')
                    ->label('tr' === $this->activeLocale ? 'Kategori Görseli' : 'Category Image')
                    ->image()
                    ->directory('categories')
                    ->disk('public')
                    ->imageEditor(),
                Toggle::make('is_active')
                    ->default(true),
            ])
            ->fillForm(function (array $arguments) {
                $cat = Category::find($arguments['id']);
                return [
                    'name' => $cat->getTranslation('name', $this->activeLocale),
                    'slug' => $cat->getTranslation('slug', $this->activeLocale),
                    'description' => $cat->getTranslation('description', $this->activeLocale),
                    'image' => $cat->image,
                    'is_active' => $cat->is_active,
                ];
            })
            ->action(function (array $data, array $arguments): void {
                $cat = Category::find($arguments['id']);
                if ($cat) {
                    $cat->setTranslation('name', $this->activeLocale, $data['name']);
                    $cat->setTranslation('slug', $this->activeLocale, $data['slug']);
                    $cat->setTranslation('description', $this->activeLocale, $data['description']);
                    $cat->image = $data['image'];
                    $cat->is_active = $data['is_active'];
                    $cat->save();

                    Notification::make()
                        ->title('Kategori güncellendi')
                        ->success()
                        ->send();
                }
                $this->loadCategories();
            })
            ->extraModalActions([
                Action::make('delete')
                    ->label('Sil / Delete')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (array $arguments): void {
                        $cat = Category::find($arguments['id']);
                        if ($cat) {
                            MenuItem::where('category_id', $cat->id)->delete();
                            $cat->delete();
                            Notification::make()
                                ->title('Kategori ve içerisindeki ürünler silindi')
                                ->success()
                                ->send();
                        }
                        $this->loadCategories();
                    })
            ]);
    }

    public function createCategoryAction(): Action
    {
        return Action::make('createCategory')
            ->form([
                TextInput::make('name')
                    ->label('Kategori Adı (' . strtoupper($this->activeLocale) . ')')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, \Filament\Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                TextInput::make('slug')
                    ->label('Slug (' . strtoupper($this->activeLocale) . ')')
                    ->required(),
                Textarea::make('description')
                    ->label('Açıklama (' . strtoupper($this->activeLocale) . ')')
                    ->rows(2),
                FileUpload::make('image')
                    ->label('tr' === $this->activeLocale ? 'Kategori Görseli' : 'Category Image')
                    ->image()
                    ->directory('categories')
                    ->disk('public')
                    ->imageEditor(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])
            ->action(function (array $data): void {
                $cat = new Category();
                $cat->parent_id = $this->selectedMainCategoryId;
                $cat->setTranslation('name', $this->activeLocale, $data['name']);
                $cat->setTranslation('slug', $this->activeLocale, $data['slug']);
                if (isset($data['description'])) {
                    $cat->setTranslation('description', $this->activeLocale, $data['description']);
                }
                $cat->image = $data['image'] ?? null;
                $cat->is_active = $data['is_active'];
                $cat->order_column = Category::where('parent_id', $this->selectedMainCategoryId)->max('order_column') + 1;
                $cat->save();
                
                Notification::make()
                    ->title('Kategori oluşturuldu')
                    ->success()
                    ->send();
                    
                $this->loadCategories();
            });
    }

    public function createItemAction(): Action
    {
        return Action::make('createItem')
            ->form([
                Tabs::make('Item Form')
                    ->tabs([
                        Tabs\Tab::make('tr' === $this->activeLocale ? 'Temel Bilgiler' : 'Basic Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('tr' === $this->activeLocale ? 'Ürün Adı' : 'Product Name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, \Filament\Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                        TextInput::make('price')
                                            ->label('tr' === $this->activeLocale ? 'Fiyat' : 'Price')
                                            ->numeric()
                                            ->prefix('₺')
                                            ->required(),
                                    ]),
                                Textarea::make('description')
                                    ->label('tr' === $this->activeLocale ? 'Açıklama / Menü Detayı' : 'Description / Menu Details')
                                    ->rows(3)
                                    ->placeholder('tr' === $this->activeLocale ? 'Müşterilerinize ürünü tanıtın...' : 'Introduce the product to your customers...'),
                                
                                Grid::make(2)
                                    ->schema([
                                        Select::make('category_id')
                                            ->label('tr' === $this->activeLocale ? 'Kategori' : 'Category')
                                            ->options(function() {
                                                $mainCat = Category::find($this->selectedMainCategoryId);
                                                $options = [];
                                                if ($mainCat) {
                                                    $options[$mainCat->id] = 'Genel Ürünler (' . $mainCat->getTranslation('name', $this->activeLocale) . ')';
                                                }
                                                $subcats = Category::where('parent_id', $this->selectedMainCategoryId)->get();
                                                foreach ($subcats as $sub) {
                                                    $options[$sub->id] = $sub->getTranslation('name', $this->activeLocale);
                                                }
                                                return $options;
                                            })
                                            ->required(),
                                        TextInput::make('allergen_info')
                                            ->label('tr' === $this->activeLocale ? 'Alerjen Bilgisi' : 'Allergen Info')
                                            ->placeholder('tr' === $this->activeLocale ? 'Örn: Kuruyemiş, Süt, Glüten' : 'e.g. Nuts, Dairy, Gluten'),
                                    ]),
                                
                                Grid::make(4)
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('tr' === $this->activeLocale ? 'Sitede Aktif' : 'Active on Site'),
                                        Toggle::make('is_featured')
                                            ->label('tr' === $this->activeLocale ? 'Öne Çıkan' : 'Featured Item'),
                                        Toggle::make('is_vegan')
                                            ->label('tr' === $this->activeLocale ? '🌱 Vegan' : '🌱 Vegan'),
                                        Toggle::make('is_vegetarian')
                                            ->label('tr' === $this->activeLocale ? '🥦 Vejetaryen' : '🥦 Vegetarian'),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-50/50 dark:bg-gray-800/30 p-4 rounded-xl border border-gray-150 dark:border-gray-800']),
                                
                                Grid::make(2)
                                    ->schema([
                                        Toggle::make('contains_alcohol')
                                            ->label('tr' === $this->activeLocale ? '🍷 Alkol İçerir' : '🍷 Contains Alcohol'),
                                        TextInput::make('calories')
                                            ->label('tr' === $this->activeLocale ? '🔥 Kalori (kcal)' : '🔥 Calories (kcal)')
                                            ->numeric()
                                            ->placeholder('Örn: 250'),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-50/30 dark:bg-gray-800/20 p-4 rounded-xl border border-gray-150/80 dark:border-gray-800/80 mt-2']),
                            ]),
                        Tabs\Tab::make('tr' === $this->activeLocale ? 'Görsel & Ek Bilgiler' : 'Media & Extras')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('tr' === $this->activeLocale ? 'Ürün Görseli' : 'Product Image')
                                    ->image()
                                    ->directory('menu-items')
                                    ->disk('public')
                                    ->imageEditor(),
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->helperText('tr' === $this->activeLocale ? 'URL uzantısı (Otomatik üretilir)' : 'URL slug (Auto-generated)'),
                                TextInput::make('likes_count')
                                    ->label('tr' === $this->activeLocale ? 'Beğeni Sayısı' : 'Likes Count')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ])
            ->fillForm(fn (array $arguments) => [
                'category_id' => $arguments['categoryId'] ?? $this->selectedMainCategoryId,
                'is_active' => true,
                'is_featured' => false,
                'is_vegan' => false,
                'is_vegetarian' => false,
                'contains_alcohol' => false,
                'calories' => null,
                'likes_count' => 0,
            ])
            ->action(function (array $data, array $arguments): void {
                $item = new MenuItem();
                $item->category_id = $data['category_id'] ?? $arguments['categoryId'];
                $item->setTranslation('name', $this->activeLocale, $data['name']);
                $item->setTranslation('slug', $this->activeLocale, $data['slug']);
                if (isset($data['description'])) {
                    $item->setTranslation('description', $this->activeLocale, $data['description']);
                }
                if (isset($data['allergen_info'])) {
                    $item->setTranslation('allergen_info', $this->activeLocale, $data['allergen_info']);
                }
                $item->price = $data['price'];
                $item->image = $data['image'] ?? null;
                $item->is_active = $data['is_active'];
                $item->is_featured = $data['is_featured'] ?? false;
                $item->is_vegan = $data['is_vegan'] ?? false;
                $item->is_vegetarian = $data['is_vegetarian'] ?? false;
                $item->contains_alcohol = $data['contains_alcohol'] ?? false;
                $item->calories = $data['calories'] ?? null;
                $item->likes_count = $data['likes_count'] ?? 0;
                
                $maxOrder = MenuItem::where('category_id', $item->category_id)->max('order_column');
                $item->order_column = $maxOrder + 1;
                
                $item->save();
                
                Notification::make()
                    ->title('Ürün oluşturuldu')
                    ->success()
                    ->send();
                    
                $this->loadCategories();
            });
    }

    public function deleteItemAction(): Action
    {
        return Action::make('deleteItem')
            ->requiresConfirmation()
            ->color('danger')
            ->action(function (array $arguments) {
                $item = MenuItem::find($arguments['id']);
                if ($item) {
                    $item->delete();
                    Notification::make()
                        ->title('Ürün silindi')
                        ->success()
                        ->send();
                }
                $this->loadCategories();
            });
    }

    public function deleteCategoryAction(): Action
    {
        return Action::make('deleteCategory')
            ->requiresConfirmation()
            ->color('danger')
            ->action(function (array $arguments) {
                $cat = Category::find($arguments['id']);
                if ($cat) {
                    MenuItem::where('category_id', $cat->id)->delete();
                    $cat->delete();
                    Notification::make()
                        ->title('Kategori ve içerisindeki ürünler silindi')
                        ->success()
                        ->send();
                }
                $this->loadCategories();
            });
    }

    public function createMainCategoryAction(): Action
    {
        return Action::make('createMainCategory')
            ->form([
                TextInput::make('name')
                    ->label('Üst Menü Adı (' . strtoupper($this->activeLocale) . ')')
                    ->required(),
                FileUpload::make('image')
                    ->label('tr' === $this->activeLocale ? 'Kategori Görseli (Geniş / Yatay)' : 'Category Image (Wide)')
                    ->image()
                    ->directory('categories')
                    ->disk('public')
                    ->imageEditor(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])
            ->action(function (array $data): void {
                $cat = new Category();
                $cat->parent_id = null;
                $cat->setTranslation('name', $this->activeLocale, $data['name']);
                $cat->setTranslation('slug', $this->activeLocale, \Illuminate\Support\Str::slug($data['name']));
                $cat->image = $data['image'] ?? null;
                $cat->is_active = $data['is_active'];
                $cat->order_column = Category::whereNull('parent_id')->max('order_column') + 1;
                $cat->save();

                Notification::make()
                    ->title('Üst kategori oluşturuldu')
                    ->success()
                    ->send();

                $this->mainCategories = Category::whereNull('parent_id')->orderBy('order_column')->get();
                $this->selectedMainCategoryId = $cat->id;
                $this->loadCategories();
            });
    }

    public function editMainCategoryAction(): Action
    {
        return Action::make('editMainCategory')
            ->form([
                TextInput::make('name')
                    ->label('Üst Menü Adı (' . strtoupper($this->activeLocale) . ')')
                    ->required(),
                FileUpload::make('image')
                    ->label('tr' === $this->activeLocale ? 'Kategori Görseli (Geniş / Yatay)' : 'Category Image (Wide)')
                    ->image()
                    ->directory('categories')
                    ->disk('public')
                    ->imageEditor(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])
            ->fillForm(function () {
                $cat = Category::find($this->selectedMainCategoryId);
                return [
                    'name' => $cat ? $cat->getTranslation('name', $this->activeLocale) : '',
                    'image' => $cat ? $cat->image : null,
                    'is_active' => $cat ? $cat->is_active : true,
                ];
            })
            ->action(function (array $data): void {
                $cat = Category::find($this->selectedMainCategoryId);
                if ($cat) {
                    $cat->setTranslation('name', $this->activeLocale, $data['name']);
                    $cat->setTranslation('slug', $this->activeLocale, \Illuminate\Support\Str::slug($data['name']));
                    $cat->image = $data['image'];
                    $cat->is_active = $data['is_active'];
                    $cat->save();

                    Notification::make()
                        ->title('Üst kategori güncellendi')
                        ->success()
                        ->send();

                    $this->mainCategories = Category::whereNull('parent_id')->orderBy('order_column')->get();
                    $this->loadCategories();
                }
            })
            ->extraModalActions([
                Action::make('delete')
                    ->label('Sil / Delete')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (): void {
                        $cat = Category::find($this->selectedMainCategoryId);
                        if ($cat) {
                            // Delete subcategories and their items
                            $subcats = Category::where('parent_id', $cat->id)->get();
                            foreach ($subcats as $sub) {
                                MenuItem::where('category_id', $sub->id)->delete();
                                $sub->delete();
                            }
                            MenuItem::where('category_id', $cat->id)->delete();
                            $cat->delete();

                            Notification::make()
                                ->title('Üst kategori ve bağlı alt kategoriler silindi')
                                ->success()
                                ->send();

                            $this->mainCategories = Category::whereNull('parent_id')->orderBy('order_column')->get();
                            $this->selectedMainCategoryId = $this->mainCategories->first()?->id;
                            $this->loadCategories();
                        }
                    })
            ]);
    }

    public function deleteMainCategoryAction(): Action
    {
        return Action::make('deleteMainCategory')
            ->requiresConfirmation()
            ->color('danger')
            ->action(function () {
                $cat = Category::find($this->selectedMainCategoryId);
                if ($cat) {
                    // Delete subcategories and their items
                    $subcats = Category::where('parent_id', $cat->id)->get();
                    foreach ($subcats as $sub) {
                        MenuItem::where('category_id', $sub->id)->delete();
                        $sub->delete();
                    }
                    MenuItem::where('category_id', $cat->id)->delete();
                    $cat->delete();

                    Notification::make()
                        ->title('Üst kategori ve bağlı alt kategoriler silindi')
                        ->success()
                        ->send();

                    $this->mainCategories = Category::whereNull('parent_id')->orderBy('order_column')->get();
                    $this->selectedMainCategoryId = $this->mainCategories->first()?->id;
                    $this->loadCategories();
                }
            });
    }


    public function render()
    {
        return view('livewire.admin.menu-board');
    }
}
