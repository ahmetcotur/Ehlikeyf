<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Clear old data
        MenuItem::query()->delete();
        Category::query()->delete();

        // Level 1: Main Parent Categories
        $snackCat = Category::create([
            'name' => ['en' => 'Snack Menu', 'tr' => 'Snack Menüsü'],
            'slug' => ['en' => 'snack-menu', 'tr' => 'snack-menusu'],
            'description' => ['en' => 'Light bites to share with your wine.', 'tr' => 'Şarabınız eşliğinde paylaşabileceğiniz atıştırmalıklar.'],
            'is_active' => true,
            'order_column' => 1,
        ]);
        
        $foodCat = Category::create([
            'name' => ['en' => 'Food Menu', 'tr' => 'Yemek Menüsü'],
            'slug' => ['en' => 'food-menu', 'tr' => 'yemek-menusu'],
            'description' => ['en' => 'Fresh seafood and premium local recipes.', 'tr' => 'Özenle hazırlanmış günlük deniz ürünleri ve yemek tabakları.'],
            'is_active' => true,
            'order_column' => 2,
        ]);
        
        $drinkCat = Category::create([
            'name' => ['en' => 'Drink Menu', 'tr' => 'İçecek Menüsü'],
            'slug' => ['en' => 'drink-menu', 'tr' => 'icecek-menusu'],
            'description' => ['en' => 'Signature sunset cocktails and a curated local wines.', 'tr' => 'Aromatik imza kokteyllerimiz, özel şarap ve içecek kavımız.'],
            'is_active' => true,
            'order_column' => 3,
        ]);


        // Level 2 & Items
        
        /* --------------------------
         * 1. SNACK MENU
         * --------------------------*/
        $this->seedItems($snackCat->id, [
            ['tr' => 'HAMBURGER', 'en' => 'Hamburger (Not available during dinner)', 'price' => 500],
            ['tr' => 'SERPME KAHVALTI (TEK KİŞİLİK)', 'en' => 'Mixed Breakfast (Per Person)', 'price' => 750],
        ]);

        /* --------------------------
         * 2. FOOD MENU
         * --------------------------*/
        $catMezeler = Category::create(['parent_id' => $foodCat->id, 'name' => ['en' => 'Mezze', 'tr' => 'Mezeler'], 'order_column' => 1, 'is_active' => true]);
        $this->seedItems($catMezeler->id, [
            ['tr' => 'YOĞURTLU MEZELER', 'en' => 'Yogurt Meze Selection', 'price' => 250],
            ['tr' => 'ZEYTİNYAĞLI MEZELER', 'en' => 'Olive Oil Meze Selection', 'price' => 300],
            ['tr' => 'DENİZ ÜRÜNLERİ MEZELER', 'en' => 'Seafood Meze Selection', 'price' => 350],
        ]);

        $catAraSicaklar = Category::create(['parent_id' => $foodCat->id, 'name' => ['en' => 'Hot Starters', 'tr' => 'Ara Sıcaklar'], 'order_column' => 2, 'is_active' => true]);
        $this->seedItems($catAraSicaklar->id, [
            ['tr' => 'ÖZEL SOSLU İSTİRİDYE MANTAR', 'en' => 'Oyster Mushroom with Special Sauce', 'price' => 500],
            ['tr' => 'KARİDES ŞİŞ', 'en' => 'Shrimp Skewer', 'price' => 600],
            ['tr' => 'KARİDES SWEET CHİLİ SPECİAL', 'en' => 'Sweet Chili Shrimp Special', 'price' => 600],
            ['tr' => 'KALAMAR TAVA', 'en' => 'Fried Calamari', 'price' => 700],
            ['tr' => 'TEREYAĞLI KARİDES', 'en' => 'Shrimp in Butter', 'price' => 700],
            ['tr' => 'YAPRAK CİĞER', 'en' => 'Thinly Sliced Fried Liver', 'price' => 600],
        ]);

        $catAnaYemekler = Category::create(['parent_id' => $foodCat->id, 'name' => ['en' => 'Main Courses', 'tr' => 'Ana Yemekler'], 'order_column' => 3, 'is_active' => true]);
        $this->seedItems($catAnaYemekler->id, [
            ['tr' => 'AHTAPOT IZGARA', 'en' => 'Grilled Octopus', 'price' => 1100],
            ['tr' => 'ELİA SPECİAL SOSLU AHTAPOT', 'en' => 'Elia Special Octopus with Sauce', 'price' => 900],
            ['tr' => 'ELIA SPECİAL ÇİPURA FİLETO', 'en' => 'Elia Special Sea Bream Fillet', 'price' => 900],
            ['tr' => 'CİPURA IZGARA', 'en' => 'Grilled Sea Bream', 'price' => 700],
            ['tr' => 'LEVREK IZGARA', 'en' => 'Grilled Sea Bass', 'price' => 700],
            ['tr' => 'SOMON', 'en' => 'Salmon', 'price' => 850],
            ['tr' => 'ŞEVKETİ BOSTANLI LEVREK', 'en' => 'Sea Bass with Blessed Thistle', 'price' => 800],
            ['tr' => 'FESLEĞEN SOSLU LEVREK', 'en' => 'Sea Bass with Basil Sauce', 'price' => 750],
            ['tr' => 'HELLİMLİ LEVREK SARMA', 'en' => 'Sea Bass Wrapped with Halloumi', 'price' => 900],
            ['tr' => 'IZGARA JUMBO KARİDES', 'en' => 'Grilled Jumbo Shrimp', 'price' => 1200],
            ['tr' => 'DANA KAVURMA', 'en' => 'Roasted Beef', 'price' => 1000],
            ['tr' => 'KUZU PİRZOLA', 'en' => 'Lamb Chops', 'price' => 1200],
            ['tr' => 'TAVUK PİRZOLA', 'en' => 'Chicken Chops', 'price' => 600],
            ['tr' => 'KÖFTE IZGARA', 'en' => 'Grilled Meatballs', 'price' => 700],
            ['tr' => 'EV YAPIMI MANTI', 'en' => 'Homemade Turkish Ravioli', 'price' => 500],
        ]);

        $catSalatalar = Category::create(['parent_id' => $foodCat->id, 'name' => ['en' => 'Salads', 'tr' => 'Salatalar'], 'order_column' => 4, 'is_active' => true]);
        $this->seedItems($catSalatalar->id, [
            ['tr' => 'ROKA SALATA', 'en' => 'Arugula Salad', 'price' => 350],
            ['tr' => 'GREEK SALATA', 'en' => 'Greek Salad', 'price' => 350],
            ['tr' => 'YEŞİL SALATA', 'en' => 'Green Salad', 'price' => 350],
            ['tr' => 'ÇOBAN SALATA', 'en' => 'Shepherd Salad', 'price' => 350],
            ['tr' => 'AVOKADOLU MEVSİM SALATA', 'en' => 'Seasonal Salad with Avocado', 'price' => 400],
        ]);
        
        $catTatlilar = Category::create(['parent_id' => $foodCat->id, 'name' => ['en' => 'Desserts', 'tr' => 'Tatlılar'], 'order_column' => 5, 'is_active' => true]);
        $this->seedItems($catTatlilar->id, [
            ['tr' => 'FIRINDA SICAK HELVA', 'en' => 'Hot Baked Halva', 'price' => 400],
            ['tr' => 'DONDURMALI İNCİR TATLISI', 'en' => 'Fig Dessert with Ice Cream', 'price' => 400],
            ['tr' => 'MEYVE TABAĞI', 'en' => 'Fruit Platter', 'price' => 500],
        ]);

        /* --------------------------
         * 3. DRINK MENU
         * --------------------------*/
        $catSaraplar = Category::create(['parent_id' => $drinkCat->id, 'name' => ['en' => 'Wines', 'tr' => 'Şaraplar'], 'order_column' => 1, 'is_active' => true]);
        $this->seedItems($catSaraplar->id, [
            ['tr' => 'LİKYA PATARA BEYAZ ŞARAP 75 CL', 'en' => 'Likya Patara White Wine 75 CL', 'price' => 2000],
            ['tr' => 'LİKYA PATARA KIRMIZI ŞARAP 75 CL', 'en' => 'Likya Patara Red Wine 75 CL', 'price' => 2000],
            ['tr' => 'SMYRNA BEYAZ ŞARAP 75 CL', 'en' => 'Smyrna White Wine 75 CL', 'price' => 2500],
            ['tr' => 'SMYRNA KIRMIZI ŞARAP 75 CL', 'en' => 'Smyrna Red Wine 75 CL', 'price' => 2500],
            ['tr' => 'SMYRNA BLUSH ŞARAP 75 CL', 'en' => 'Smyrna Blush Wine 75 CL', 'price' => 2500],
            ['tr' => 'LİKYA PATARA KIZILBEL KIRMIZI', 'en' => 'Likya Patara Kizilbel Red', 'price' => 2500],
            ['tr' => 'KAYRA SAUVIGNON BLACK BEYAZ', 'en' => 'Kayra Sauvignon Black White', 'price' => 2500],
            ['tr' => 'KAYRA ALLURE KALECİK KARASI ROSE', 'en' => 'Kayra Allure Kalecik Karasi Rose', 'price' => 2500],
            ['tr' => 'LİKYA PATARA BEYAZ KADEH', 'en' => 'Likya Patara White Wine Glass', 'price' => 450],
            ['tr' => 'LİKYA PATARA KIRMIZI KADEH', 'en' => 'Likya Patara Red Wine Glass', 'price' => 450],
            ['tr' => 'LİKYA PATARA KIZILBEL KIRMIZI KADEH', 'en' => 'Likya Patara Kizilbel Red Glass', 'price' => 500],
            ['tr' => 'SMYRNA BEYAZ ŞARAP KADEH', 'en' => 'Smyrna White Wine Glass', 'price' => 500],
            ['tr' => 'SMYRNA KIRMIZI ŞARAP KADEH', 'en' => 'Smyrna Red Wine Glass', 'price' => 500],
            ['tr' => 'SMYRNA BLUSH ŞARAP KADEH', 'en' => 'Smyrna Blush Wine Glass', 'price' => 500],
            ['tr' => 'KAYRA SAUVIGNON BLACK BEYAZ KADEH', 'en' => 'Kayra Sauvignon Black White Glass', 'price' => 500],
        ]);

        $catRakilar = Category::create(['parent_id' => $drinkCat->id, 'name' => ['en' => 'Rakis', 'tr' => 'Rakılar'], 'order_column' => 2, 'is_active' => true]);
        $this->seedItems($catRakilar->id, [
            ['tr' => 'BEYLERBEYİ GÖBEK 20 CL', 'en' => 'Beylerbeyi Gobek Raki 20 CL', 'price' => 1100],
            ['tr' => 'BEYLERBEYİ GÖBEK 35 CL', 'en' => 'Beylerbeyi Gobek Raki 35 CL', 'price' => 1700],
            ['tr' => 'BEYLERBEYİ GÖBEK 50 CL', 'en' => 'Beylerbeyi Gobek Raki 50 CL', 'price' => 2100],
            ['tr' => 'BEYLERBEYİ GÖBEK 70 CL', 'en' => 'Beylerbeyi Gobek Raki 70 CL', 'price' => 2700],
            ['tr' => 'BEYLERBEYİ GÖBEK 100 CL', 'en' => 'Beylerbeyi Gobek Raki 100 CL', 'price' => 3200],
            ['tr' => 'TEKİRDAĞ ALTINSERİ 20 CL', 'en' => 'Tekirdag Altinseri Raki 20 CL', 'price' => 1100],
            ['tr' => 'TEKİRDAĞ ALTINSERİ 35 CL', 'en' => 'Tekirdag Altinseri Raki 35 CL', 'price' => 1700],
            ['tr' => 'TEKİRDAĞ ALTINSERİ 50 CL', 'en' => 'Tekirdag Altinseri Raki 50 CL', 'price' => 2100],
            ['tr' => 'TEKİRDAĞ ALTINSERİ 70 CL', 'en' => 'Tekirdag Altinseri Raki 70 CL', 'price' => 2700],
            ['tr' => 'TEKİRDAĞ ALTINSERİ 100 CL', 'en' => 'Tekirdag Altinseri Raki 100 CL', 'price' => 3200],
        ]);

        $catIcecekler = Category::create(['parent_id' => $drinkCat->id, 'name' => ['en' => 'Beverages', 'tr' => 'İçecekler'], 'order_column' => 3, 'is_active' => true]);
        $this->seedItems($catIcecekler->id, [
            ['tr' => 'TUBORG 50 CL', 'en' => 'Tuborg 50 CL', 'price' => 250],
            ['tr' => 'CARLSBERG 50 CL', 'en' => 'Carlsberg 50 CL', 'price' => 250],
            ['tr' => 'KOLA / FANTA / SPRİTE', 'en' => 'Cola / Fanta / Sprite', 'price' => 150],
            ['tr' => 'SU', 'en' => 'Water', 'price' => 100],
        ]);
        
    }

    private function seedItems($parentId, $itemsArray)
    {
        foreach($itemsArray as $i => $item) {
            MenuItem::create([
                'category_id' => $parentId,
                'name' => ['en' => ucwords(strtolower($item['en'])), 'tr' => mb_convert_case($item['tr'], MB_CASE_TITLE, "UTF-8")],
                'slug' => ['en' => Str::slug($item['en']), 'tr' => Str::slug($item['tr'])],
                'price' => $item['price'],
                'is_active' => true,
                'order_column' => $i + 1,
            ]);
        }
    }
}
