<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Support\Str;

class MeyhaneMenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear old data completely
        MenuItem::query()->delete();
        Category::query()->delete();

        // 2. Level 1: Main Parent Categories
        $mezeCat = Category::create([
            'name' => ['en' => 'Meze Menu', 'tr' => 'Meze Menüsü'],
            'slug' => ['en' => 'meze-menu', 'tr' => 'meze-menusu'],
            'description' => ['en' => 'Traditional cold starters and local appetizers.', 'tr' => 'Geleneksel soğuk mezeler ve yöresel başlangıçlar.'],
            'is_active' => true,
            'order_column' => 1,
        ]);
        
        $foodCat = Category::create([
            'name' => ['en' => 'Food Menu', 'tr' => 'Yemek Menüsü'],
            'slug' => ['en' => 'food-menu', 'tr' => 'yemek-menusu'],
            'description' => ['en' => 'Traditional main dishes, grills and casseroles.', 'tr' => 'Ana yemekler, ızgaralar, güveçler ve steak çeşitleri.'],
            'is_active' => true,
            'order_column' => 2,
        ]);
        
        $drinkCat = Category::create([
            'name' => ['en' => 'Drink Menu', 'tr' => 'İçecek Menüsü'],
            'slug' => ['en' => 'drink-menu', 'tr' => 'icecek-menusu'],
            'description' => ['en' => 'Traditional Turkish Rakis, select wines, and cold beverages.', 'tr' => 'Meyhane klasiği rakılar, seçkin şaraplar ve soğuk içecekler.'],
            'is_active' => true,
            'order_column' => 3,
        ]);

        // 3. Level 2: Subcategories and their Items

        // ------------------ MEZE MENÜSÜ ------------------
        
        // Başlangıçlar
        $catBaslangiclar = Category::create([
            'parent_id' => $mezeCat->id,
            'name' => ['en' => 'Starters', 'tr' => 'Başlangıçlar'],
            'slug' => ['en' => 'starters', 'tr' => 'baslangiclar'],
            'order_column' => 1,
            'is_active' => true
        ]);
        $this->seedGroupItems($catBaslangiclar->id, [
            [
                'name' => ['tr' => 'Balık Çorbası', 'en' => 'Fish Soup'],
                'description' => ['tr' => 'Taze Akdeniz balıklarından hazırlanan lezzetli balık çorbası.', 'en' => 'Delicious soup prepared with fresh Mediterranean fish.'],
                'price' => 550, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 180, 'allergen_info' => ['tr' => 'Balık', 'en' => 'Fish']
            ],
            [
                'name' => ['tr' => 'Domates Çorbası', 'en' => 'Tomato Soup'],
                'description' => ['tr' => 'Közlenmiş domates ve taze baharatlarla hazırlanan sıcak başlangıç.', 'en' => 'Warm starter prepared with roasted tomatoes and fresh herbs.'],
                'price' => 400, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 120, 'allergen_info' => ['tr' => 'Süt Ürünü (Gluten opsiyonel)', 'en' => 'Dairy (Gluten optional)']
            ],
        ]);

        // Günlük Soğuk Mezeler
        $catSogukMezeler = Category::create([
            'parent_id' => $mezeCat->id,
            'name' => ['en' => 'Daily Cold Mezes', 'tr' => 'Günlük Soğuk Mezeler'],
            'slug' => ['en' => 'daily-cold-mezes', 'tr' => 'gunluk-soguk-mezeler'],
            'order_column' => 2,
            'is_active' => true
        ]);
        $this->seedGroupItems($catSogukMezeler->id, [
            [
                'name' => ['tr' => 'Meze Çeşitleri (Adet)', 'en' => 'Cold Mezes (Each)'],
                'description' => ['tr' => 'Günlük taze olarak hazırlanan zeytinyağlı meze çeşitlerimiz.', 'en' => 'Daily fresh prepared cold meze options selection.'],
                'price' => 350, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 150, 'allergen_info' => ['tr' => 'Süt Ürünü (bazı çeşitlerde)', 'en' => 'Dairy (in some options)']
            ],
            [
                'name' => ['tr' => 'Deniz Ürünleri Mezeleri (Adet)', 'en' => 'Seafood Mezes (Each)'],
                'description' => ['tr' => 'Özel marine edilmiş taze deniz ürünleri mezelerimiz.', 'en' => 'Specially marinated fresh seafood meze selection.'],
                'price' => 550, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 190, 'allergen_info' => ['tr' => 'Balık, Kabuklular, Yumuşakçalar', 'en' => 'Fish, Crustaceans, Molluscs']
            ],
        ]);

        // Ara Sıcaklar
        $catAraSicaklar = Category::create([
            'parent_id' => $mezeCat->id,
            'name' => ['en' => 'Warm Apperatives', 'tr' => 'Ara Sıcaklar'],
            'slug' => ['en' => 'warm-apperatives', 'tr' => 'ara-sicaklar'],
            'order_column' => 3,
            'is_active' => true
        ]);
        $this->seedGroupItems($catAraSicaklar->id, [
            [
                'name' => ['tr' => 'Kalamar Tava', 'en' => 'Fried Calamari'],
                'description' => ['tr' => 'Çıtır kızartılmış kalamar halkaları, ev yapımı tarator sos ile.', 'en' => 'Crispy fried calamari rings served with homemade tartar sauce.'],
                'price' => 900, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 380, 'allergen_info' => ['tr' => 'Yumuşakçalar, Gluten, Yumurta', 'en' => 'Molluscs, Gluten, Eggs']
            ],
            [
                'name' => ['tr' => 'İspanyol Karides (Acılı)', 'en' => 'Spanish Shrimp (Spicy)'],
                'description' => ['tr' => 'Pul biber, taze sarımsak ve özel zeytinyağı sosunda acılı karides.', 'en' => 'Spicy shrimps cooked in chili flakes, fresh garlic, and olive oil sauce.'],
                'price' => 950, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 310, 'allergen_info' => ['tr' => 'Kabuklular', 'en' => 'Crustaceans']
            ],
            [
                'name' => ['tr' => 'Tereyağlı Sarımsaklı Karides Tava', 'en' => 'Fried Shrimp with Butter & Garlic'],
                'description' => ['tr' => 'Güveçte tereyağı, sarımsak ve taze baharatlarla cızırdayan taze karidesler.', 'en' => 'Fresh shrimps sizzling in a clay pot with butter, garlic, and fresh herbs.'],
                'price' => 900, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 340, 'allergen_info' => ['tr' => 'Kabuklular, Süt Ürünü (Laktoz)', 'en' => 'Crustaceans, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Kalamar Izgara', 'en' => 'Grilled Calamari'],
                'description' => ['tr' => 'Kömür ateşinde ızgara yapılmış yumuşacık bütün kalamar tüpü.', 'en' => 'Charcoal-grilled tender whole calamari tube.'],
                'price' => 1100, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 220, 'allergen_info' => ['tr' => 'Yumuşakçalar', 'en' => 'Molluscs']
            ],
            [
                'name' => ['tr' => 'Midye Tava', 'en' => 'Fried Mussels'],
                'description' => ['tr' => 'Şişe dizilmiş çıtır kızartılmış midye içleri, tarator sos ile.', 'en' => 'Crispy fried mussels on skewers served with tartar sauce.'],
                'price' => 900, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 290, 'allergen_info' => ['tr' => 'Yumuşakçalar, Gluten', 'en' => 'Molluscs, Gluten']
            ],
            [
                'name' => ['tr' => 'Ahtapot Izgara', 'en' => 'Grilled Octopus'],
                'description' => ['tr' => 'Kömür ateşinde tütsülenmiş zeytinyağlı ahtapot bacağı.', 'en' => 'Charcoal-grilled tender octopus arm marinated with olive oil.'],
                'price' => 1250, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 240, 'allergen_info' => ['tr' => 'Yumuşakçalar', 'en' => 'Molluscs']
            ],
            [
                'name' => ['tr' => 'Kalamar Dolma', 'en' => 'Stuffed Calamari'],
                'description' => ['tr' => 'İçi peynir ve deniz ürünleri harcı ile doldurulmuş ızgara kalamar dolması.', 'en' => 'Grilled whole calamari stuffed with cheese and seafood blend.'],
                'price' => 1250, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 450, 'allergen_info' => ['tr' => 'Yumuşakçalar, Süt Ürünü (Laktoz)', 'en' => 'Molluscs, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Levrek Simit', 'en' => 'Sea Bass Roll'],
                'description' => ['tr' => 'Milföy hamuruna sarılmış peynirli nefis levrek rulosu.', 'en' => 'Delicious sea bass roll stuffed with cheese wrapped in puff pastry.'],
                'price' => 750, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 390, 'allergen_info' => ['tr' => 'Balık, Gluten, Süt Ürünü (Laktoz)', 'en' => 'Fish, Gluten, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Sarımsaklı Kaşarlı Mantar', 'en' => 'Garlic and Cheese Mushrooms'],
                'description' => ['tr' => 'Fırında sarımsak, tereyağı ve erimiş kaşar peynirli mantarlar.', 'en' => 'Oven-baked mushrooms with garlic, butter, and melted kashar cheese.'],
                'price' => 650, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 220, 'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Kızarmış Peynir', 'en' => 'Grilled Cheese'],
                'description' => ['tr' => 'Tavada altın sarısı kızartılmış özel hellim peyniri.', 'en' => 'Pan-fried golden halloumi cheese slices.'],
                'price' => 400, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 310, 'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Paçanga Böreği (Pastırma - Kaşar)', 'en' => 'Pacanga Pastry (Pastrami - Cheese)'],
                'description' => ['tr' => 'Çıtır yufka içinde çemenli pastırma, domates, biber ve eriyen kaşar peyniri.', 'en' => 'Crispy pastry wrapped with pastrami, tomatoes, peppers, and melted kashar.'],
                'price' => 600, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 420, 'allergen_info' => ['tr' => 'Gluten, Süt Ürünü (Laktoz)', 'en' => 'Gluten, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Sigara Böreği', 'en' => 'Cheese Roll'],
                'description' => ['tr' => 'Çıtır yufka içinde lor peyniri ve maydanozlu çıtır börekler.', 'en' => 'Crispy pastry rolls filled with curd cheese and parsley.'],
                'price' => 550, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 280, 'allergen_info' => ['tr' => 'Gluten, Süt Ürünü (Laktoz)', 'en' => 'Gluten, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Patates Kızartması', 'en' => 'French Fries'],
                'description' => ['tr' => 'Çıtır altın sarısı parmak patates kızartması.', 'en' => 'Crispy golden french fries.'],
                'price' => 350, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 310, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
        ]);


        // ------------------ YEMEK MENÜSÜ ------------------
        
        // Bonfileler / Steaks
        $catSteaks = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Steaks', 'tr' => 'Bonfileler'],
            'slug' => ['en' => 'steaks', 'tr' => 'bonfileler'],
            'description' => ['en' => 'Served with Vegetables, Pilav and French Fries.', 'tr' => 'Sebze Garnitür, Pilav ve Patates Kızartması ile servis edilir.'],
            'order_column' => 1,
            'is_active' => true
        ]);
        $this->seedGroupItems($catSteaks->id, [
            [
                'name' => ['tr' => 'Acılı Bonfile', 'en' => 'Pepper Steak'],
                'description' => ['tr' => 'Özel acı sos ve baharatlarla marine edilmiş ızgara bonfile dilimleri.', 'en' => 'Grilled beef steak slices marinated with special spicy sauce.'],
                'price' => 1700, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 580, 'allergen_info' => ['tr' => 'Gluten (sos kaynaklı)', 'en' => 'Gluten (from sauce)']
            ],
            [
                'name' => ['tr' => 'Mantar Soslu Bonfile', 'en' => 'Steak with Mushroom Sauce'],
                'description' => ['tr' => 'Kremalı taze mantar sosu eşliğinde ızgara bonfile.', 'en' => 'Grilled beef steak served with creamy fresh mushroom sauce.'],
                'price' => 1700, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 640, 'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Sade Bonfile', 'en' => 'Grilled Steak'],
                'description' => ['tr' => 'Kömür ateşinde ızgara yapılmış marine dana bonfile.', 'en' => 'Charcoal-grilled marinated beef tenderloin steak.'],
                'price' => 1600, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 490, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
        ]);

        // Tavuk Yemekleri
        $catTavuk = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Chicken Dishes', 'tr' => 'Tavuk Yemekleri'],
            'slug' => ['en' => 'chicken-dishes', 'tr' => 'tavuk-yemekleri'],
            'description' => ['en' => 'Served with Vegetables, Pilav and French Fries.', 'tr' => 'Sebze Garnitür, Pilav ve Patates Kızartması ile servis edilir.'],
            'order_column' => 2,
            'is_active' => true
        ]);
        $this->seedGroupItems($catTavuk->id, [
            [
                'name' => ['tr' => 'Mantar Soslu Tavuk', 'en' => 'Chicken with Mushroom Sauce'],
                'description' => ['tr' => 'Kremalı taze mantar soslu tavuk göğsü filetosu.', 'en' => 'Chicken breast fillet cooked in creamy fresh mushroom sauce.'],
                'price' => 800, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 520, 'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Tavuk Köri', 'en' => 'Chicken with Curry'],
                'description' => ['tr' => 'Köri baharatı ve krema sosunda pişirilmiş sote tavuk dilimleri.', 'en' => 'Sauteed chicken slices cooked in curry spices and cream sauce.'],
                'price' => 800, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 540, 'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Tavuk Şinitzel', 'en' => 'Chicken Schnitzel'],
                'description' => ['tr' => 'Altın sarısı panelenip kızartılmış çıtır tavuk göğsü filetosu.', 'en' => 'Golden breaded and fried crispy chicken breast fillet.'],
                'price' => 800, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 580, 'allergen_info' => ['tr' => 'Gluten, Yumurta', 'en' => 'Gluten, Eggs']
            ],
        ]);

        // Makarnalar / Pastas
        $catPastas = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Pastas', 'tr' => 'Makarnalar'],
            'slug' => ['en' => 'pastas', 'tr' => 'makarnalar'],
            'order_column' => 3,
            'is_active' => true
        ]);
        $this->seedGroupItems($catPastas->id, [
            [
                'name' => ['tr' => 'Kıymalı Penne', 'en' => 'Penne Bolognese'],
                'description' => ['tr' => 'Geleneksel kıymalı bolognese soslu kalem makarna.', 'en' => 'Penne pasta with traditional minced beef bolognese sauce.'],
                'price' => 750, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 610, 'allergen_info' => ['tr' => 'Gluten, Kereviz', 'en' => 'Gluten, Celery']
            ],
            [
                'name' => ['tr' => 'Kremalı Tavuk Penne', 'en' => 'Penne with Chicken and Cream'],
                'description' => ['tr' => 'Kremalı sos eşliğinde tavuk dilimleri ve mantarlı penne.', 'en' => 'Penne pasta with chicken slices and mushrooms in creamy sauce.'],
                'price' => 750, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 650, 'allergen_info' => ['tr' => 'Gluten, Süt Ürünü (Laktoz)', 'en' => 'Gluten, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Fesleğen Soslu Penne', 'en' => 'Penne with Pesto Sauce'],
                'description' => ['tr' => 'Taze fesleğenli pesto sosu ve zeytinyağlı penne makarna.', 'en' => 'Penne pasta cooked in fresh basil pesto and olive oil.'],
                'price' => 700, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 520, 'allergen_info' => ['tr' => 'Gluten, Süt Ürünü (Peynir, Çam Fıstığı)', 'en' => 'Gluten, Dairy (Cheese, Pine Nuts)']
            ],
            [
                'name' => ['tr' => 'Deniz Ürünleri Penne', 'en' => 'Penne with Seafood'],
                'description' => ['tr' => 'Kalamar, karides ve midye eşliğinde hafif domates soslu penne.', 'en' => 'Penne pasta cooked with calamari, shrimp, and mussels in light tomato sauce.'],
                'price' => 1100, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 580, 'allergen_info' => ['tr' => 'Gluten, Kabuklular, Yumuşakçalar', 'en' => 'Gluten, Crustaceans, Molluscs']
            ],
        ]);

        // Izgaralar / Grills
        $catGrills = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Grills', 'tr' => 'Izgaralar'],
            'slug' => ['en' => 'grills', 'tr' => 'izgaralar'],
            'description' => ['en' => 'Served with Rice, French Fries and Grilled Vegetables.', 'tr' => 'Pilav, Patates Kızartması ve Izgara Sebzelerle Servis Edilir.'],
            'order_column' => 4,
            'is_active' => true
        ]);
        $this->seedGroupItems($catGrills->id, [
            [
                'name' => ['tr' => 'Ful Karışık Izgara (2 Kişilik)', 'en' => 'Mixed Full Grill (For 2)'],
                'description' => ['tr' => 'Köfte, Tavuk Pirzola, Kuzu Şiş ve Adana Kebap. Çift kişilik zengin sunum.', 'en' => 'Meatballs, Grilled Chicken, Lamb Shish, and Adana Kebab. Rich double platter.'],
                'price' => 5500, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 1800, 'allergen_info' => ['tr' => 'Gluten', 'en' => 'Gluten']
            ],
            [
                'name' => ['tr' => 'Pirzola', 'en' => 'Lamb Chops'],
                'description' => ['tr' => 'Kömür ateşinde pişmiş taze kuzu pirzolaları.', 'en' => 'Charcoal-grilled tender fresh lamb chops.'],
                'price' => 1500, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 690, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Kuzu Şiş', 'en' => 'Lamb Shish'],
                'description' => ['tr' => 'Közlenmiş domates ve biber eşliğinde marine kuzu şiş.', 'en' => 'Marinated lamb cubes grilled on skewers with tomatoes and peppers.'],
                'price' => 1100, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 610, 'allergen_info' => ['tr' => 'Gluten (lavaş)', 'en' => 'Gluten (flatbread)']
            ],
            [
                'name' => ['tr' => 'Tavuk Şiş', 'en' => 'Chicken Shish'],
                'description' => ['tr' => 'Özel sosla marine edilmiş tavuk göğsü şiş.', 'en' => 'Marinated skewered chicken breast cubes grilled to perfection.'],
                'price' => 750, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 450, 'allergen_info' => ['tr' => 'Gluten (lavaş)', 'en' => 'Gluten (flatbread)']
            ],
            [
                'name' => ['tr' => 'Izgara Köfte', 'en' => 'Grilled Meatballs'],
                'description' => ['tr' => 'Kömür ateşinde ızgara yapılmış geleneksel dana ve kuzu köfteleri.', 'en' => 'Charcoal-grilled traditional beef and lamb meatballs.'],
                'price' => 800, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 590, 'allergen_info' => ['tr' => 'Gluten, Yumurta', 'en' => 'Gluten, Eggs']
            ],
            [
                'name' => ['tr' => 'Izgara Bonfile', 'en' => 'Grilled Steak'],
                'description' => ['tr' => 'Kömür ızgarasında pişirilmiş marine edilmiş dilim bonfile.', 'en' => 'Charcoal-grilled marinated beef tenderloin slices.'],
                'price' => 1600, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 490, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Karışık Izgara', 'en' => 'Mixed Grill'],
                'description' => ['tr' => 'Izgara köfte, tavuk şiş, pirzola ve kuzu şiş karışık porsiyon.', 'en' => 'A select combo plate of meatballs, chicken shish, lamb chop, and lamb shish.'],
                'price' => 1400, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 850, 'allergen_info' => ['tr' => 'Gluten', 'en' => 'Gluten']
            ],
        ]);

        // Güveçler / Casseroles
        $catCasseroles = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Casseroles', 'tr' => 'Güveçler'],
            'slug' => ['en' => 'casseroles', 'tr' => 'guvecler'],
            'description' => ['en' => 'Served with Rice, French Fries and Seasonal Greens.', 'tr' => 'Pilav, Patates Kızartması ve Mevsim Yeşillikleri Servis Edilir.'],
            'order_column' => 5,
            'is_active' => true
        ]);
        $this->seedGroupItems($catCasseroles->id, [
            [
                'name' => ['tr' => 'Tavuk Güveç', 'en' => 'Chicken Casserole'],
                'description' => ['tr' => 'Toprak güveçte sebzeler ve domates soslu tavuk sote.', 'en' => 'Chicken breast cubes sautéed with mixed vegetables in clay pot.'],
                'price' => 850, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 480, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Ahtapot Güveç', 'en' => 'Octopus Casserole'],
                'description' => ['tr' => 'Güveçte tereyağı, sarımsak, domates, biber ve ahtapot dilimleri.', 'en' => 'Octopus slices baked in clay pot with butter, garlic, tomatoes, and peppers.'],
                'price' => 1250, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 380, 'allergen_info' => ['tr' => 'Yumuşakçalar, Süt Ürünü (Tereyağı)', 'en' => 'Molluscs, Dairy (Butter)']
            ],
            [
                'name' => ['tr' => 'Karides Güveç', 'en' => 'Shrimp Casserole'],
                'description' => ['tr' => 'Fırınlanmış güveçte kaşar peyniri, domates ve tereyağlı karidesler.', 'en' => 'Shrimps baked in clay pot with tomatoes, garlic, butter, and melted kashar.'],
                'price' => 1100, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 420, 'allergen_info' => ['tr' => 'Kabuklular, Süt Ürünü (Laktoz)', 'en' => 'Crustaceans, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Kuzu Güveç', 'en' => 'Lamb Casserole'],
                'description' => ['tr' => 'Güveçte ağır ateşte pişmiş marine kuzu eti ve sebzeler.', 'en' => 'Slow-cooked marinated lamb cubes with mixed vegetables in clay pot.'],
                'price' => 1100, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 630, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Deniz Ürünleri Güveç', 'en' => 'Seafood Casserole'],
                'description' => ['tr' => 'Balık, kalamar, karides ve midyeli zengin karışık güveç.', 'en' => 'Rich seafood medley baked in clay pot with tomatoes and garlic.'],
                'price' => 1400, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 490, 'allergen_info' => ['tr' => 'Balık, Kabuklular, Yumuşakçalar', 'en' => 'Fish, Crustaceans, Molluscs']
            ],
            [
                'name' => ['tr' => 'Sebze Güveç', 'en' => 'Vegetable Casserole'],
                'description' => ['tr' => 'Taze mevsim sebzelerinin güveçte özel baharatlı sotesi.', 'en' => 'Seasonal mixed vegetables sautéed in a clay pot with special spices.'],
                'price' => 750, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 210, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
        ]);

        // Deniz Ürünleri / Seafood
        $catSeafood = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Seafood', 'tr' => 'Deniz Ürünleri'],
            'slug' => ['en' => 'seafood', 'tr' => 'deniz-urunleri'],
            'description' => ['en' => 'Served with Mediterranean Greens, Tomatoes, Onion, Lemon and French Fries.', 'tr' => 'Akdeniz Yeşillikleri, Domates, Limon, Soğan ve Patates Kızartması ile Servis Edilir.'],
            'order_column' => 6,
            'is_active' => true
        ]);
        $this->seedGroupItems($catSeafood->id, [
            [
                'name' => ['tr' => 'Ehl-i Keyf Deniz Tepsisi (2 Kişilik)', 'en' => 'Ehl-i Keyf Sea Platter (For 2)'],
                'description' => ['tr' => 'Kalamar, Karides, Levrek, Kılıç Şiş, Ahtapot ve Dil Balığı. Çift kişilik deniz ziyafeti.', 'en' => 'Calamari, Shrimp, Seabass, Swordfish, Octopus, and Sole Fish combo platter.'],
                'price' => 5250, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 1200, 'allergen_info' => ['tr' => 'Balık, Kabuklular, Yumuşakçalar', 'en' => 'Fish, Crustaceans, Molluscs']
            ],
            [
                'name' => ['tr' => 'Çupra Izgara', 'en' => 'Grilled Sea Bream'],
                'description' => ['tr' => 'Izgara çipura balığı, yeşillik ve patates kızartması eşliğinde.', 'en' => 'Charcoal-grilled fresh sea bream served with greens and fries.'],
                'price' => 900, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 450, 'allergen_info' => ['tr' => 'Balık', 'en' => 'Fish']
            ],
            [
                'name' => ['tr' => 'Levrek Izgara', 'en' => 'Grilled Sea Bass'],
                'description' => ['tr' => 'Kömür ateşinden taze ızgara levrek fileto.', 'en' => 'Charcoal-grilled fresh sea bass fillet served with side salad.'],
                'price' => 900, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 430, 'allergen_info' => ['tr' => 'Balık', 'en' => 'Fish']
            ],
            [
                'name' => ['tr' => 'Kılıç Şiş Izgara', 'en' => 'Grilled Sword Fish'],
                'description' => ['tr' => 'Şişe dizilmiş ızgara kılıç balığı lokumları ve defne yaprağı.', 'en' => 'Grilled swordfish cubes on skewers with bay leaves.'],
                'price' => 1200, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 380, 'allergen_info' => ['tr' => 'Balık', 'en' => 'Fish']
            ],
            [
                'name' => ['tr' => 'Dil Tava', 'en' => 'Fried Sole Fish'],
                'description' => ['tr' => 'Tavada unlanıp tereyağında kızartılmış nefis dil balığı.', 'en' => 'Pan-fried sole fish fillets in butter.'],
                'price' => 950, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 410, 'allergen_info' => ['tr' => 'Balık, Gluten, Süt Ürünü', 'en' => 'Fish, Gluten, Dairy']
            ],
            [
                'name' => ['tr' => 'Jumbo Karides Izgara', 'en' => 'Grilled Jumbo Shrimp'],
                'description' => ['tr' => 'Kömür ateşinde ızgara yapılmış dev jumbo karidesler.', 'en' => 'Charcoal-grilled fresh jumbo prawns with special butter glaze.'],
                'price' => 1200, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 290, 'allergen_info' => ['tr' => 'Kabuklular, Süt Ürünü', 'en' => 'Crustaceans, Dairy']
            ],
            [
                'name' => ['tr' => 'Somon Izgara', 'en' => 'Grilled Salmon'],
                'description' => ['tr' => 'Izgara somon filetosu, fırın patates ve roka salatası eşliğinde.', 'en' => 'Grilled salmon fillet served with baby potatoes and arugula.'],
                'price' => 1000, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 580, 'allergen_info' => ['tr' => 'Balık', 'en' => 'Fish']
            ],
            [
                'name' => ['tr' => 'Günlük Deniz Balıkları', 'en' => 'Daily Sea Fish'],
                'description' => ['tr' => 'Mevsimine göre günlük taze balıklar. Kilo ile fiyatlandırılır.', 'en' => 'Daily fresh seasonal fish options. Priced by weight (kg).'],
                'price' => 0, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => null, 'allergen_info' => ['tr' => 'Balık', 'en' => 'Fish']
            ],
        ]);

        // Salatalar / Salads
        $catSalads = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Salads', 'tr' => 'Salatalar'],
            'slug' => ['en' => 'salads', 'tr' => 'salatalar'],
            'order_column' => 7,
            'is_active' => true
        ]);
        $this->seedGroupItems($catSalads->id, [
            [
                'name' => ['tr' => 'Ehl-i Keyf Salata', 'en' => 'Ehl-i Keyf Salad'],
                'description' => ['tr' => 'Özel nar ekşisi soslu, cevizli ve peynirli spesiyal salata.', 'en' => 'House special salad with walnuts, cheese, and pomegranate dressing.'],
                'price' => 550, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 240, 'allergen_info' => ['tr' => 'Kuruyemiş (Ceviz), Süt Ürünü (Peynir)', 'en' => 'Nuts (Walnut), Dairy (Cheese)']
            ],
            [
                'name' => ['tr' => 'Roka Salata', 'en' => 'Rocket Salad'],
                'description' => ['tr' => 'Taze roka yaprakları, çeri domates ve rendelenmiş peynir.', 'en' => 'Fresh arugula leaves, cherry tomatoes, and grated cheese.'],
                'price' => 450, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 160, 'allergen_info' => ['tr' => 'Süt Ürünü (Peynir)', 'en' => 'Dairy (Cheese)']
            ],
            [
                'name' => ['tr' => 'Çoban Salata', 'en' => 'Shepherd Salad'],
                'description' => ['tr' => 'İnce kıyılmış domates, salatalık, biber, taze soğan ve maydanoz salatası.', 'en' => 'Finely chopped tomatoes, cucumbers, peppers, green onions, and parsley.'],
                'price' => 450, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 110, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Yeşil Salata', 'en' => 'Green Salad'],
                'description' => ['tr' => 'Mevsim yeşillikleri, zeytinyağı ve limon soslu taze salata.', 'en' => 'Fresh seasonal greens tossed in lemon and olive oil dressing.'],
                'price' => 450, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 95, 'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Gavurdağı Salata', 'en' => 'Gavurdagi Salad'],
                'description' => ['tr' => 'İnce kıyılmış domates, bol ceviz, nar ekşisi ve zeytinyağlı salata.', 'en' => 'Finely diced tomatoes with walnuts, pomegranate molasses, and olive oil.'],
                'price' => 450, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 280, 'allergen_info' => ['tr' => 'Kuruyemiş (Ceviz)', 'en' => 'Nuts (Walnut)']
            ],
            [
                'name' => ['tr' => 'Hellim Roka Salata', 'en' => 'Halloumi Rocket Salad'],
                'description' => ['tr' => 'Izgara hellim peyniri dilimleri, taze roka yaprakları ve çeri domatesler.', 'en' => 'Grilled halloumi cheese slices on bed of fresh rocket and cherry tomatoes.'],
                'price' => 500, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 310, 'allergen_info' => ['tr' => 'Süt Ürünü (Hellim)', 'en' => 'Dairy (Halloumi)']
            ],
        ]);

        // Tatlılar / Desserts
        $catDesserts = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Desserts', 'tr' => 'Tatlılar'],
            'slug' => ['en' => 'desserts', 'tr' => 'tatlilar'],
            'order_column' => 8,
            'is_active' => true
        ]);
        $this->seedGroupItems($catDesserts->id, [
            [
                'name' => ['tr' => 'Fırında Tahin Helvası', 'en' => 'Baked Halvah'],
                'description' => ['tr' => 'Fırında sıcak tereyağlı ve limonlu geleneksel tahin helvası.', 'en' => 'Traditional warm tahini halva baked with butter and lemon.'],
                'price' => 500, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 380, 'allergen_info' => ['tr' => 'Susam, Süt Ürünü (Laktoz)', 'en' => 'Sesame, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Doğal Tava Dondurma', 'en' => 'Natural Pan Ice Cream'],
                'description' => ['tr' => 'Doğal meyvelerle taze hazırlanmış rulo tava dondurma.', 'en' => 'Freshly rolled pan ice cream prepared with natural fruits.'],
                'price' => 300, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 190, 'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Dondurmalı İncir Kavurması', 'en' => 'Roasted Fig with Ice Cream'],
                'description' => ['tr' => 'Tavada karamelize edilmiş kuru incir, vanilyalı dondurma eşliğinde.', 'en' => 'Oven-roasted dry figs caramelized and served with vanilla ice cream.'],
                'price' => 600, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 290, 'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Dondurmalı İrmik Helvası', 'en' => 'Semolina Halva with Ice Cream'],
                'description' => ['tr' => 'İçi vanilyalı dondurma dolgulu sıcak irmik helvası.', 'en' => 'Warm semolina halva stuffed with vanilla ice cream.'],
                'price' => 600, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 340, 'allergen_info' => ['tr' => 'Gluten, Süt Ürünü (Laktoz)', 'en' => 'Gluten, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Makara Tatlısı', 'en' => 'Chimney Cake'],
                'description' => ['tr' => 'Tarçın ve şeker kaplı sıcak silindir makara tatlısı.', 'en' => 'Freshly baked warm chimney cake rolled in cinnamon and sugar.'],
                'price' => 500, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 320, 'allergen_info' => ['tr' => 'Gluten, Yumurta', 'en' => 'Gluten, Eggs']
            ],
        ]);


        // ------------------ İÇECEK MENÜSÜ ------------------
        
        // Rakılar / Raki
        $catRakilar = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Rakis', 'tr' => 'Rakılar'],
            'slug' => ['en' => 'rakis', 'tr' => 'rakilar'],
            'order_column' => 1,
            'is_active' => true
        ]);
        $this->seedGroupItems($catRakilar->id, [
            // Yeni Rakı 1937
            ['name' => ['tr' => 'Yeni Rakı 1937 20cl', 'en' => 'Yeni Raki 1937 20cl'], 'description' => ['tr' => '20cl şişe.', 'en' => '20cl bottle.'], 'price' => 1200, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 450, 'allergen_info' => null],
            ['name' => ['tr' => 'Yeni Rakı 1937 35cl', 'en' => 'Yeni Raki 1937 35cl'], 'description' => ['tr' => '35cl şişe.', 'en' => '35cl bottle.'], 'price' => 1700, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 780, 'allergen_info' => null],
            ['name' => ['tr' => 'Yeni Rakı 1937 50cl', 'en' => 'Yeni Raki 1937 50cl'], 'description' => ['tr' => '50cl şişe.', 'en' => '50cl bottle.'], 'price' => 2300, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1100, 'allergen_info' => null],
            ['name' => ['tr' => 'Yeni Rakı 1937 70cl', 'en' => 'Yeni Raki 1937 70cl'], 'description' => ['tr' => '70cl şişe.', 'en' => '70cl bottle.'], 'price' => 2750, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1540, 'allergen_info' => null],
            ['name' => ['tr' => 'Yeni Rakı 1937 100cl', 'en' => 'Yeni Raki 1937 100cl'], 'description' => ['tr' => '100cl şişe.', 'en' => '100cl bottle.'], 'price' => 3400, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 2200, 'allergen_info' => null],

            // Tekirdağ Altın Seri
            ['name' => ['tr' => 'Tekirdağ Altın Seri 20cl', 'en' => 'Tekirdag Gold Series 20cl'], 'description' => ['tr' => '20cl şişe. Meşe fıçıda olgunlaştırılmış.', 'en' => '20cl bottle. Aged in oak barrels.'], 'price' => 1350, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 450, 'allergen_info' => null],
            ['name' => ['tr' => 'Tekirdağ Altın Seri 35cl', 'en' => 'Tekirdag Gold Series 35cl'], 'description' => ['tr' => '35cl şişe.', 'en' => '35cl bottle.'], 'price' => 2200, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 785, 'allergen_info' => null],
            ['name' => ['tr' => 'Tekirdağ Altın Seri 50cl', 'en' => 'Tekirdag Gold Series 50cl'], 'description' => ['tr' => '50cl şişe.', 'en' => '50cl bottle.'], 'price' => 2800, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1120, 'allergen_info' => null],
            ['name' => ['tr' => 'Tekirdağ Altın Seri 70cl', 'en' => 'Tekirdag Gold Series 70cl'], 'description' => ['tr' => '70cl şişe.', 'en' => '70cl bottle.'], 'price' => 3500, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1570, 'allergen_info' => null],
            ['name' => ['tr' => 'Tekirdağ Altın Seri 100cl', 'en' => 'Tekirdag Gold Series 100cl'], 'description' => ['tr' => '100cl şişe.', 'en' => '100cl bottle.'], 'price' => 4300, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 2240, 'allergen_info' => null],

            // Efe Gold
            ['name' => ['tr' => 'Efe Gold 20cl', 'en' => 'Efe Gold Raki 20cl'], 'description' => ['tr' => '20cl şişe.', 'en' => '20cl bottle.'], 'price' => 1300, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 450, 'allergen_info' => null],
            ['name' => ['tr' => 'Efe Gold 35cl', 'en' => 'Efe Gold Raki 35cl'], 'description' => ['tr' => '35cl şişe.', 'en' => '35cl bottle.'], 'price' => 2100, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 785, 'allergen_info' => null],
            ['name' => ['tr' => 'Efe Gold 50cl', 'en' => 'Efe Gold Raki 50cl'], 'description' => ['tr' => '50cl şişe.', 'en' => '50cl bottle.'], 'price' => 2700, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1120, 'allergen_info' => null],
            ['name' => ['tr' => 'Efe Gold 70cl', 'en' => 'Efe Gold Raki 70cl'], 'description' => ['tr' => '70cl şişe.', 'en' => '70cl bottle.'], 'price' => 3400, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1570, 'allergen_info' => null],
            ['name' => ['tr' => 'Efe Gold 100cl', 'en' => 'Efe Gold Raki 100cl'], 'description' => ['tr' => '100cl şişe.', 'en' => '100cl bottle.'], 'price' => 4200, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 2240, 'allergen_info' => null],

            // Beylerbeyi Göbek
            ['name' => ['tr' => 'Beylerbeyi Göbek 20cl', 'en' => 'Beylerbeyi Gobek 20cl'], 'description' => ['tr' => '20cl şişe. 3 kez distile edilmiş premium.', 'en' => '20cl bottle. Triple-distilled premium.'], 'price' => 1400, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 460, 'allergen_info' => null],
            ['name' => ['tr' => 'Beylerbeyi Göbek 35cl', 'en' => 'Beylerbeyi Gobek 35cl'], 'description' => ['tr' => '35cl şişe.', 'en' => '35cl bottle.'], 'price' => 2300, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 800, 'allergen_info' => null],
            ['name' => ['tr' => 'Beylerbeyi Göbek 50cl', 'en' => 'Beylerbeyi Gobek 50cl'], 'description' => ['tr' => '50cl şişe.', 'en' => '50cl bottle.'], 'price' => 2900, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1150, 'allergen_info' => null],
            ['name' => ['tr' => 'Beylerbeyi Göbek 70cl', 'en' => 'Beylerbeyi Gobek 70cl'], 'description' => ['tr' => '70cl şişe.', 'en' => '70cl bottle.'], 'price' => 3600, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1610, 'allergen_info' => null],
            ['name' => ['tr' => 'Beylerbeyi Göbek 100cl', 'en' => 'Beylerbeyi Gobek 100cl'], 'description' => ['tr' => '100cl şişe.', 'en' => '100cl bottle.'], 'price' => 4500, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 2300, 'allergen_info' => null],

            // Tekirdağ Göbek
            ['name' => ['tr' => 'Tekirdağ Göbek 20cl', 'en' => 'Tekirdag Gobek 20cl'], 'description' => ['tr' => '20cl şişe.', 'en' => '20cl bottle.'], 'price' => 1300, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 450, 'allergen_info' => null],
            ['name' => ['tr' => 'Tekirdağ Göbek 35cl', 'en' => 'Tekirdag Gobek 35cl'], 'description' => ['tr' => '35cl şişe.', 'en' => '35cl bottle.'], 'price' => 2150, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 785, 'allergen_info' => null],
            ['name' => ['tr' => 'Tekirdağ Göbek 50cl', 'en' => 'Tekirdag Gobek 50cl'], 'description' => ['tr' => '50cl şişe.', 'en' => '50cl bottle.'], 'price' => 2750, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1120, 'allergen_info' => null],
            ['name' => ['tr' => 'Tekirdağ Göbek 70cl', 'en' => 'Tekirdag Gobek 70cl'], 'description' => ['tr' => '70cl şişe.', 'en' => '70cl bottle.'], 'price' => 3450, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1570, 'allergen_info' => null],
            ['name' => ['tr' => 'Tekirdağ Göbek 100cl', 'en' => 'Tekirdag Gobek 100cl'], 'description' => ['tr' => '100cl şişe.', 'en' => '100cl bottle.'], 'price' => 4300, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 2240, 'allergen_info' => null],

            // Kulüp Deluxe
            ['name' => ['tr' => 'Kulüp Deluxe 35cl', 'en' => 'Kulup Deluxe 35cl'], 'description' => ['tr' => '35cl şişe.', 'en' => '35cl bottle.'], 'price' => 2100, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 780, 'allergen_info' => null],
            ['name' => ['tr' => 'Kulüp Deluxe 70cl', 'en' => 'Kulup Deluxe 70cl'], 'description' => ['tr' => '70cl şişe.', 'en' => '70cl bottle.'], 'price' => 3400, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1560, 'allergen_info' => null],
            ['name' => ['tr' => 'Kulüp Deluxe 100cl', 'en' => 'Kulup Deluxe 100cl'], 'description' => ['tr' => '100cl şişe.', 'en' => '100cl bottle.'], 'price' => 4200, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 2200, 'allergen_info' => null],

            // Bardak / Tek / Duble
            ['name' => ['tr' => 'Tek Rakı', 'en' => 'Single Raki'], 'description' => ['tr' => 'Tek duble/ölçek bardakta sunum.', 'en' => 'Single shot glass presentation.'], 'price' => 450, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 120, 'allergen_info' => null],
            ['name' => ['tr' => 'Duble Rakı', 'en' => 'Double Raki'], 'description' => ['tr' => 'Duble ölçü bardakta sunum.', 'en' => 'Double shot glass presentation.'], 'price' => 600, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 240, 'allergen_info' => null],
        ]);

        // Beyaz Şaraplar
        $catWhiteWines = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'White Wines', 'tr' => 'Beyaz Şaraplar'],
            'slug' => ['en' => 'white-wines', 'tr' => 'beyaz-saraplar'],
            'order_column' => 2,
            'is_active' => true
        ]);
        $this->seedGroupItems($catWhiteWines->id, [
            ['name' => ['tr' => 'Kayra Buzbağ Rezerv Emir Narince 75cl', 'en' => 'Kayra Buzbag Rezerv Emir Narince 75cl'], 'description' => ['tr' => 'Kapadokya Emir ve Tokat Narince üzümlerinden zengin bitişli sek beyaz şarap.', 'en' => 'Rich dry white wine made from Cappadocia Emir and Tokat Narince grapes.'], 'price' => 2200, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 580, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Kayra Allure Sauvignon Blanc 75cl', 'en' => 'Kayra Allure Sauvignon Blanc 75cl'], 'description' => ['tr' => 'Narenciye aromaları ve canlı asiditeli sek beyaz şarap.', 'en' => 'Dry white wine with citrus aromas and lively acidity.'], 'price' => 2700, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 570, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Kayra Allure Chardonnay 75cl', 'en' => 'Kayra Allure Chardonnay 75cl'], 'description' => ['tr' => 'Tropikal meyve notları ve ferahlatıcı bitişli sek beyaz şarap.', 'en' => 'Dry white wine with tropical fruit notes and refreshing finish.'], 'price' => 2600, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 580, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Kayra Vintage Narince 75cl', 'en' => 'Kayra Vintage Narince 75cl'], 'description' => ['tr' => 'Meşe fıçılarda olgunlaştırılmış, gövdeli premium beyaz şarap.', 'en' => 'Full-bodied premium white wine aged in oak barrels.'], 'price' => 3000, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 600, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Kayra Versus Chardonnay / Viognier', 'en' => 'Kayra Versus Chardonnay / Viognier'], 'description' => ['tr' => 'Zengin meyvemsi aromalar ve kadifemsi dokulu özel kupaj beyaz şarap.', 'en' => 'Special blend white wine with rich fruity aromas and velvety texture.'], 'price' => 4000, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 610, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
        ]);

        // Kırmızı Şaraplar
        $catRedWines = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Red Wines', 'tr' => 'Kırmızı Şaraplar'],
            'slug' => ['en' => 'red-wines', 'tr' => 'kirmizi-saraplar'],
            'order_column' => 3,
            'is_active' => true
        ]);
        $this->seedGroupItems($catRedWines->id, [
            ['name' => ['tr' => 'Kayra Buzbağ Rezerv Öküzgözü 75cl', 'en' => 'Kayra Buzbag Rezerv Okuzgozu 75cl'], 'description' => ['tr' => 'Geleneksel Elazığ Öküzgözü üzümlerinden olgun kırmızı meyve aromalı gövdeli şarap.', 'en' => 'Full-bodied red wine made from traditional Elazig Okuzgozu grapes with ripe red fruit aromas.'], 'price' => 2200, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 600, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Kayra Terra Merlot 75cl', 'en' => 'Kayra Terra Merlot 75cl'], 'description' => ['tr' => 'Yumuşak tanenli ve mürdüm eriği aromalı sek kırmızı şarap.', 'en' => 'Dry red wine with soft tannins and damson plum aromas.'], 'price' => 2700, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 590, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Kayra Vintage Cabernet Sauvignon 75cl', 'en' => 'Kayra Vintage Cabernet Sauvignon 75cl'], 'description' => ['tr' => 'Baharat ve meşe notları barındıran gövdeli sek kırmızı şarap.', 'en' => 'Full-bodied dry red wine with spices and oak notes.'], 'price' => 3000, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 610, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Kayra Heritage Episode Üzümlü Shiraz 75cl', 'en' => 'Kayra Heritage Episode Uzumlu Shiraz 75cl'], 'description' => ['tr' => 'Premium Shiraz kupajı, baharatlı zengin aromalara sahip sek kırmızı şarap.', 'en' => 'Premium Shiraz blend dry red wine with spicy rich aromas.'], 'price' => 4500, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 630, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
        ]);

        // Roze Şarapları
        $catRoseWines = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Rose Wines', 'tr' => 'Roze Şarapları'],
            'slug' => ['en' => 'rose-wines', 'tr' => 'roze-saraplari'],
            'order_column' => 4,
            'is_active' => true
        ]);
        $this->seedGroupItems($catRoseWines->id, [
            ['name' => ['tr' => 'Kayra Allure Rose 75cl', 'en' => 'Kayra Allure Rose 75cl'], 'description' => ['tr' => 'Taze çilek ve ahududu notalı canlı sek roze şarap.', 'en' => 'Lively dry rose wine with fresh strawberry and raspberry notes.'], 'price' => 2700, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 560, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Leona Blush 75cl', 'en' => 'Leona Blush 75cl'], 'description' => ['tr' => 'Hafif ve ferahlatıcı yazlık blush roze şarap.', 'en' => 'Light and refreshing summer blush rose wine.'], 'price' => 2800, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 540, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Ruffino Prosecco 75cl', 'en' => 'Ruffino Prosecco 75cl'], 'description' => ['tr' => 'İtalyan klasiği köpüklü şarap (Şampanya).', 'en' => 'Italian classic sparkling wine (Champaigne) for special celebrations.'], 'price' => 4500, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 520, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
        ]);

        // Alkollü İçecekler / Bira & Kadeh
        $catBeers = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Alcohol Drinks', 'tr' => 'Alkollü İçecekler'],
            'slug' => ['en' => 'alcohol-drinks', 'tr' => 'alkollu-icecekler'],
            'order_column' => 5,
            'is_active' => true
        ]);
        $this->seedGroupItems($catBeers->id, [
            ['name' => ['tr' => 'Kadeh Şarap', 'en' => 'Glass of Wine'], 'description' => ['tr' => 'Seçkin sofra şarabımızdan kadehte sunum.', 'en' => 'A single glass of our selected house table wine.'], 'price' => 500, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 150, 'allergen_info' => ['tr' => 'Sülfitler', 'en' => 'Sulfites']],
            ['name' => ['tr' => 'Bira Şişe (Tuborg Gold / Filtresiz / Carlsberg)', 'en' => 'Bottled Beer (Tuborg Gold / Unfiltered / Carlsberg)'], 'description' => ['tr' => 'Soğuk servis edilen şişe biralar.', 'en' => 'Ice-cold served bottled beers.'], 'price' => 350, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 180, 'allergen_info' => ['tr' => 'Gluten (Arpa)', 'en' => 'Gluten (Barley)']],
            ['name' => ['tr' => 'Tuborg Ice', 'en' => 'Tuborg Ice'], 'description' => ['tr' => 'Daha hafif ve ferahlatıcı soğuk bira.', 'en' => 'Light and refreshing cold beer.'], 'price' => 300, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 160, 'allergen_info' => ['tr' => 'Gluten (Arpa)', 'en' => 'Gluten (Barley)']],
        ]);

        // Sıcak İçecekler
        $catHotDrinks = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Hot Drinks', 'tr' => 'Sıcak İçecekler'],
            'slug' => ['en' => 'hot-drinks', 'tr' => 'sicak-icecekler'],
            'order_column' => 6,
            'is_active' => true
        ]);
        $this->seedGroupItems($catHotDrinks->id, [
            ['name' => ['tr' => 'Türk Kahvesi', 'en' => 'Turkish Coffee'], 'description' => ['tr' => 'Geleneksel Türk kahvesi, lokum ve su eşliğinde.', 'en' => 'Traditional Turkish coffee served with water and Turkish delight.'], 'price' => 200, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 10, 'allergen_info' => null],
            ['name' => ['tr' => 'Taze Demleme Çay', 'en' => 'Fresh Brewed Tea'], 'description' => ['tr' => 'Taze demlenmiş sıcak Türk çayı.', 'en' => 'Freshly brewed hot black Turkish tea.'], 'price' => 100, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 0, 'allergen_info' => null],
        ]);

        // Alkolsüz İçecekler
        $catSoftDrinks = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Non-Alcoholic Drinks', 'tr' => 'Alkolsüz İçecekler'],
            'slug' => ['en' => 'non-alcoholic-drinks', 'tr' => 'alkolsuz-icecekler'],
            'order_column' => 7,
            'is_active' => true
        ]);
        $this->seedGroupItems($catSoftDrinks->id, [
            ['name' => ['tr' => 'Taze Portakal Suyu', 'en' => 'Fresh Orange Juice'], 'description' => ['tr' => 'Günlük taze sıkılmış portakal suyu.', 'en' => 'Daily freshly squeezed sweet orange juice.'], 'price' => 250, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 120, 'allergen_info' => null],
            ['name' => ['tr' => 'Kutu Gazlı İçecekler (Kola, Fanta, Sprite)', 'en' => 'Canned Sodas (Cola, Fanta, Sprite)'], 'description' => ['tr' => 'Soğuk servis edilen kutu içecekler.', 'en' => 'Chilled canned carbonated beverages.'], 'price' => 130, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 140, 'allergen_info' => null],
            ['name' => ['tr' => 'Meyve Suyu (Vişne, Şeftali, Karışık)', 'en' => 'Fruit Juice (Cherry, Peach, Mixed)'], 'description' => ['tr' => 'Meyve suyu çeşitleri.', 'en' => 'Selection of packaged fruit juices.'], 'price' => 130, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 130, 'allergen_info' => null],
            ['name' => ['tr' => 'Küçük Şalgam Suyu', 'en' => 'Small Turnip Juice'], 'description' => ['tr' => 'Acılı veya acısız küçük şalgam suyu.', 'en' => 'Small bottle of spicy or mild traditional turnip juice.'], 'price' => 150, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 30, 'allergen_info' => null],
            ['name' => ['tr' => 'Büyük Şalgam Suyu', 'en' => 'Big Turnip Juice'], 'description' => ['tr' => 'Acılı veya acısız büyük şişe şalgam suyu.', 'en' => 'Large bottle of spicy or mild traditional turnip juice.'], 'price' => 300, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 60, 'allergen_info' => null],
            ['name' => ['tr' => 'Maden Suyu (Soda)', 'en' => 'Mineral Water (Soda)'], 'description' => ['tr' => 'Doğal mineralli gazlı su.', 'en' => 'Naturally carbonated mineral water.'], 'price' => 100, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 0, 'allergen_info' => null],
            ['name' => ['tr' => 'Su / Water', 'en' => 'Water / Su'], 'description' => ['tr' => 'Şişe içme suyu.', 'en' => 'Bottled drinking water.'], 'price' => 90, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 0, 'allergen_info' => null],
        ]);
    }

    private function seedGroupItems($subcatId, $items)
    {
        foreach ($items as $idx => $item) {
            $slugTr = Str::slug($item['name']['tr']);
            $slugEn = Str::slug($item['name']['en']);
            
            MenuItem::create([
                'category_id' => $subcatId,
                'name' => $item['name'],
                'slug' => ['tr' => $slugTr, 'en' => $slugEn],
                'description' => $item['description'],
                'price' => $item['price'],
                'is_vegan' => $item['is_vegan'] ?? false,
                'is_vegetarian' => $item['is_vegetarian'] ?? false,
                'contains_alcohol' => $item['contains_alcohol'] ?? false,
                'calories' => $item['calories'] ?? null,
                'allergen_info' => $item['allergen_info'] ?? null,
                'is_active' => true,
                'order_column' => $idx + 1,
            ]);
        }
    }
}
