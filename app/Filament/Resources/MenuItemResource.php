<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Filament\Resources\MenuItemResource\RelationManagers;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuItemResource extends Resource
{
    use Translatable;
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Menü Öğesi';
    protected static ?string $pluralModelLabel = 'Menü Öğeleri';
    
    protected static ?string $navigationGroup = 'Menü';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Temel Bilgiler')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Ad')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Uzantısı')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                            ]),
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->columnSpanFull()
                            ->rows(3),
                        Forms\Components\TextInput::make('price')
                            ->label('Fiyat')
                            ->numeric()
                            ->prefix('₺')
                            ->required(),
                        Forms\Components\TextInput::make('likes_count')
                            ->numeric()
                            ->default(0)
                            ->label('Beğeni Sayısı'),
                    ]),

                Forms\Components\Section::make('Diyet & Sağlık')
                    ->schema([
                        Forms\Components\Toggle::make('is_vegan')
                            ->label('Vegan / Vejetaryen')
                            ->default(false),
                        Forms\Components\TextInput::make('allergen_info')
                            ->label('Alerjen Bilgisi')
                            ->placeholder('Örn: Kuruyemiş, Süt, Gluten'),
                    ]),

                Forms\Components\Section::make('Medya & Görünürlük')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Görsel')
                            ->image()
                            ->directory('menu-items')
                            ->disk('public')
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('1200')
                            ->imageEditor(),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Öne Çıkan')
                                    ->default(false),
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif mi')
                                    ->default(true),
                                Forms\Components\TextInput::make('order_column')
                                    ->label('Sıralama')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Görsel')
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Fiyat')
                    ->money('TRY')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Öne Çıkan'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\ViewColumn::make('likes_count')
                    ->label('Beğeni')
                    ->sortable()
                    ->view('filament.tables.columns.editable-likes'),
                Tables\Columns\TextColumn::make('order_column')
                    ->label('Sıralama')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('category.name')
                    ->label('Kategori')
                    ->collapsible(),
            ])
            ->defaultGroup('category.name')
            ->reorderable('order_column')
            ->defaultSort('order_column');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
