<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Session;
use App\Services\ExchangeRateService;

class Menu extends Component
{
    public $activeCategory = null;
    public $activeSubcategory = null;
    public $categorySlug = null;
    public $subcategorySlug = null;
    
    public $currency = 'TRY';
    public $usdRate = 1.0;

    public function mount($category = null, $subcategory = null)
    {
        $this->currency = Session::get('menu_currency', 'TRY');
        $tryPerUsd = app(ExchangeRateService::class)->getUsdToTryRate();
        $this->usdRate = $tryPerUsd > 0 ? (1 / $tryPerUsd) : 0;
        if ($category) {
            // Route-based slug: /menu/food-menu
            $cat = Category::where('slug->en', $category)
                           ->orWhere('slug->tr', $category)
                           ->first();
            if ($cat) {
                $this->activeCategory = $cat->id;
                $this->categorySlug = $category;
            }
        } elseif (request()->query('c')) {
            // Legacy fallback: /menu?c=20
            $this->activeCategory = (int) request()->query('c');
            $cat = Category::find($this->activeCategory);
            if ($cat) {
                $this->categorySlug = $cat->getTranslation('slug', 'en');
            }
        }

        if ($subcategory && $this->activeCategory) {
            $subcat = Category::where('parent_id', $this->activeCategory)
                              ->where(function($q) use ($subcategory) {
                                  $q->where('slug->en', $subcategory)
                                    ->orWhere('slug->tr', $subcategory);
                              })
                              ->first();
            if ($subcat) {
                $this->activeSubcategory = $subcat->id;
                $this->subcategorySlug = $subcategory;
            }
        }
    }

    public function selectCategory($id)
    {
        $this->activeCategory = $id;
        $cat = Category::find($id);
        if ($cat) {
            $slug = $cat->getTranslation('slug', app()->getLocale()) ?: $cat->getTranslation('slug', 'en');
            return $this->redirect(route('menu', ['category' => $slug]), navigate: true);
        }
    }

    public function backToCategories()
    {
        $this->activeCategory = null;
        $this->activeSubcategory = null;
        return $this->redirect(route('menu'), navigate: true);
    }



    public function setCurrency($currency)
    {
        if (in_array($currency, ['TRY', 'USD'])) {
            $this->currency = $currency;
            Session::put('menu_currency', $currency);
        }
    }

    public function formatPrice($priceInTry)
    {
        if ($this->currency === 'USD') {
            $converted = $priceInTry * $this->usdRate;
            return '<span class="menu-item-price"><span class="menu-item-price-symbol">$</span>' . number_format($converted, 2) . '</span>';
        }
        
        return '<span class="menu-item-price">' . number_format($priceInTry, 0) . '<span class="menu-item-price-symbol">₺</span></span>';
    }

    public function render()
    {
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order_column')
            ->with(['menuItems' => function($q) {
                $q->where('is_active', true)->orderBy('order_column');
            }, 'children' => function($q) {
                $q->where('is_active', true)->orderBy('order_column');
            }, 'children.menuItems' => function($q) {
                $q->where('is_active', true)->orderBy('order_column');
            }])
            ->get();
        
        // Build page title
        $pageTitle = __('Menu');
        if ($this->activeCategory) {
            $activeCat = $categories->firstWhere('id', $this->activeCategory);
            if ($activeCat) {
                $pageTitle = $activeCat->name . ' - ' . __('Menu');
            }
        }
        
        return view('livewire.menu', [
            'categories' => $categories
        ])->title($pageTitle . ' - Ehl-i Keyf Meyhane Kaş');
    }
}
