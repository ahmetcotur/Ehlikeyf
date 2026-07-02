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
            'description' => ['en' => 'Traditional hot starters and grilled main courses.', 'tr' => 'Sıcak ara sıcaklar ve kömür ateşinden ana yemekler.'],
            'is_active' => true,
            'order_column' => 2,
        ]);
        
        $drinkCat = Category::create([
            'name' => ['en' => 'Drink Menu', 'tr' => 'İçecek Menüsü'],
            'slug' => ['en' => 'drink-menu', 'tr' => 'icecek-menusu'],
            'description' => ['en' => 'Traditional Turkish Rakis, local wines, and beverages.', 'tr' => 'Meyhane klasiği rakılar, yöresel şaraplar ve alkolsüz içecekler.'],
            'is_active' => true,
            'order_column' => 3,
        ]);

        // 3. Level 2: Subcategories and their Items
        
        // 3.1 MEZE SUB-CATEGORIES
        $catSogukMezeler = Category::create([
            'parent_id' => $mezeCat->id,
            'name' => ['en' => 'Cold Appetizers', 'tr' => 'Soğuk Mezeler'],
            'slug' => ['en' => 'cold-appetizers', 'tr' => 'soguk-mezeler'],
            'order_column' => 1,
            'is_active' => true
        ]);
        $this->seedGroupItems($catSogukMezeler->id, [
            [
                'name' => ['tr' => 'Haydari', 'en' => 'Haydari'],
                'description' => ['tr' => 'Süzme yoğurt, taze dereotu, sarımsak, taze nane ve tereyağlı sos eşliğinde.', 'en' => 'Strained yogurt, fresh dill, garlic, fresh mint, and butter sauce.'],
                'price' => 220, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 145,
                'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Köpoğlu', 'en' => 'Kopoglu'],
                'description' => ['tr' => 'Közlenmiş patlıcan, biber ve domates soslu sarımsaklı süzme yoğurt yatağında.', 'en' => 'Roasted eggplant, pepper, and tomato sauce on garlic strained yogurt.'],
                'price' => 240, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 180,
                'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Muhammara', 'en' => 'Muhammara'],
                'description' => ['tr' => 'Köz kırmızı biber, ceviz içi, tahin, sarımsak, nar ekşisi ve özel baharat karışımı.', 'en' => 'Roasted red pepper, walnut, tahini, garlic, pomegranate molasses, and special spice mix.'],
                'price' => 260, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 245,
                'allergen_info' => ['tr' => 'Gluten, Susam, Ceviz', 'en' => 'Gluten, Sesame, Walnut']
            ],
            [
                'name' => ['tr' => 'Şakşuka', 'en' => 'Saksuka'],
                'description' => ['tr' => 'Küp doğranmış kızarmış patlıcan, patates ve biber, sarımsaklı domates sosu ile.', 'en' => 'Sautéed eggplant, potato, and bell pepper with garlic-infused tomato sauce.'],
                'price' => 230, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 160,
                'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Atom', 'en' => 'Atom'],
                'description' => ['tr' => 'Süzme yoğurt yatağında tereyağında kavrulmuş acı Arnavut biberi.', 'en' => 'Strained yogurt topped with hot dried red peppers sautéed in butter.'],
                'price' => 250, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 195,
                'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Kavun ve Ezine Peyniri', 'en' => 'Melon & Ezine Feta'],
                'description' => ['tr' => 'Olgunlaşmış tam yağlı Ezine peyniri ve dilimlenmiş sulu tatlı kavun.', 'en' => 'Mature full-fat Ezine cheese served with sweet sliced melon.'],
                'price' => 280, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 210,
                'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ]
        ]);

        $catDenizMezeleri = Category::create([
            'parent_id' => $mezeCat->id,
            'name' => ['en' => 'Seafood Mezze', 'tr' => 'Deniz Mezeleri'],
            'slug' => ['en' => 'seafood-mezze', 'tr' => 'deniz-mezeleri'],
            'order_column' => 2,
            'is_active' => true
        ]);
        $this->seedGroupItems($catDenizMezeleri->id, [
            [
                'name' => ['tr' => 'Lakerda', 'en' => 'Lakerda'],
                'description' => ['tr' => 'Geleneksel yöntemle tuzlanmış torik balığı dilimleri, kırmızı soğan ve dereotu eşliğinde.', 'en' => 'Traditional salted bonito fish slices served with red onion and fresh dill.'],
                'price' => 420, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 285,
                'allergen_info' => ['tr' => 'Balık', 'en' => 'Fish']
            ],
            [
                'name' => ['tr' => 'Ahtapot Salatası', 'en' => 'Octopus Salad'],
                'description' => ['tr' => 'Zeytinyağı, limon, dereotu, taze soğan ve kapari ile marine edilmiş haşlanmış ahtapot.', 'en' => 'Boiled octopus marinated with olive oil, lemon juice, fresh dill, green onion, and capers.'],
                'price' => 450, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 220,
                'allergen_info' => ['tr' => 'Yumuşakçalar', 'en' => 'Molluscs']
            ],
            [
                'name' => ['tr' => 'Marine Levrek', 'en' => 'Marinated Sea Bass'],
                'description' => ['tr' => 'Hardal sosu, limon, zeytinyağı ve taze baharatlarla marine edilmiş levrek filetoları.', 'en' => 'Sea bass fillets marinated in mustard sauce, olive oil, lemon juice, and fresh herbs.'],
                'price' => 380, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 260,
                'allergen_info' => ['tr' => 'Balık, Hardal', 'en' => 'Fish, Mustard']
            ]
        ]);

        // 3.2 FOOD SUB-CATEGORIES
        $catAraSicaklar = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Hot Appetizers', 'tr' => 'Ara Sıcaklar'],
            'slug' => ['en' => 'hot-appetizers', 'tr' => 'ara-sicaklar'],
            'order_column' => 1,
            'is_active' => true
        ]);
        $this->seedGroupItems($catAraSicaklar->id, [
            [
                'name' => ['tr' => 'Kalamar Tava', 'en' => 'Fried Calamari'],
                'description' => ['tr' => 'Çıtır çıtır kızartılmış kalamar halkaları, ev yapımı tarator sos ile.', 'en' => 'Crispy fried calamari rings served with homemade tartar sauce.'],
                'price' => 520, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 380,
                'allergen_info' => ['tr' => 'Yumuşakçalar, Gluten, Yumurta', 'en' => 'Molluscs, Gluten, Eggs']
            ],
            [
                'name' => ['tr' => 'Tereyağında Karides', 'en' => 'Shrimp in Butter'],
                'description' => ['tr' => 'Pul biber, sarımsak ve tereyağı ile güveçte cızırdayan taze karidesler.', 'en' => 'Fresh shrimps sizzling in a clay pot with chili flakes, garlic, and butter.'],
                'price' => 550, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 310,
                'allergen_info' => ['tr' => 'Kabuklular, Süt Ürünü (Laktoz)', 'en' => 'Crustaceans, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Paçanga Böreği', 'en' => 'Pacanga Pastry'],
                'description' => ['tr' => 'Çıtır yufka içinde çemenli pastırma, eriyen kaşar peyniri, domates ve biber.', 'en' => 'Crispy pastry wrap filled with pastrami, melting kashar cheese, tomato, and pepper.'],
                'price' => 360, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 420,
                'allergen_info' => ['tr' => 'Gluten, Süt Ürünü (Laktoz)', 'en' => 'Gluten, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Yaprak Ciğer', 'en' => 'Leaf Liver'],
                'description' => ['tr' => 'Sumaklı kırmızı soğan ve maydanoz salatası eşliğinde unlanıp kızartılmış çıtır dana ciğeri dilimleri.', 'en' => 'Pan-fried thinly sliced beef liver served with sumac-spiced red onions and parsley salad.'],
                'price' => 480, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 480,
                'allergen_info' => ['tr' => 'Gluten', 'en' => 'Gluten']
            ]
        ]);

        $catAnaYemekler = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Main Dishes', 'tr' => 'Ana Yemekler'],
            'slug' => ['en' => 'main-dishes', 'tr' => 'ana-yemekler'],
            'order_column' => 2,
            'is_active' => true
        ]);
        $this->seedGroupItems($catAnaYemekler->id, [
            [
                'name' => ['tr' => 'Izgara Çipura', 'en' => 'Grilled Sea Bream'],
                'description' => ['tr' => 'Kömür ateşinde ızgara yapılmış taze çipura balığı, roka, soğan ve limon ile.', 'en' => 'Charcoal-grilled fresh sea bream served with arugula, onion, and lemon.'],
                'price' => 720, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 460,
                'allergen_info' => ['tr' => 'Balık', 'en' => 'Fish']
            ],
            [
                'name' => ['tr' => 'Kuzu Çöp Şiş', 'en' => 'Lamb Skewers'],
                'description' => ['tr' => 'Marine edilmiş kuzu but etleri, közlenmiş domates, biber ve lavaş eşliğinde.', 'en' => 'Marinated small lamb cubes on skewers, grilled tomatoes, peppers, and lavash.'],
                'price' => 780, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 620,
                'allergen_info' => ['tr' => 'Gluten', 'en' => 'Gluten']
            ],
            [
                'name' => ['tr' => 'Satır Köfte', 'en' => 'Satir Meatballs'],
                'description' => ['tr' => 'Zırhta çekilmiş özel kuzu ve dana eti karışımı ızgara köfte, sumaklı soğan ve pilav ile.', 'en' => 'Hand-minced blend of lamb and beef meatballs, served with sumac onions and rice.'],
                'price' => 650, 'is_vegan' => false, 'is_vegetarian' => false, 'contains_alcohol' => false, 'calories' => 590,
                'allergen_info' => ['tr' => 'Gluten', 'en' => 'Gluten']
            ]
        ]);

        $catTatlilar = Category::create([
            'parent_id' => $foodCat->id,
            'name' => ['en' => 'Desserts', 'tr' => 'Tatlılar'],
            'slug' => ['en' => 'desserts', 'tr' => 'tatlilar'],
            'order_column' => 3,
            'is_active' => true
        ]);
        $this->seedGroupItems($catTatlilar->id, [
            [
                'name' => ['tr' => 'Fırında Sıcak Tahin Helvası', 'en' => 'Baked Tahini Halva'],
                'description' => ['tr' => 'Fırınlanmış tereyağlı ve limonlu tahin helvası.', 'en' => 'Warm oven-baked tahini halva with butter and fresh lemon juice.'],
                'price' => 260, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 380,
                'allergen_info' => ['tr' => 'Susam, Süt Ürünü (Laktoz)', 'en' => 'Sesame, Dairy (Lactose)']
            ],
            [
                'name' => ['tr' => 'Dondurmalı İncir Uyutması', 'en' => 'Fig Pudding with Ice Cream'],
                'description' => ['tr' => 'Geleneksel kuru incir tatlısı, vanilyalı dondurma eşliğinde.', 'en' => 'Traditional milk and dried fig pudding served with vanilla ice cream.'],
                'price' => 280, 'is_vegan' => false, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 320,
                'allergen_info' => ['tr' => 'Süt Ürünü (Laktoz)', 'en' => 'Dairy (Lactose)']
            ]
        ]);

        // 3.3 DRINK SUB-CATEGORIES
        $catRakilar = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Rakis', 'tr' => 'Rakılar'],
            'slug' => ['en' => 'rakis', 'tr' => 'rakilar'],
            'order_column' => 1,
            'is_active' => true
        ]);
        $this->seedGroupItems($catRakilar->id, [
            [
                'name' => ['tr' => 'Yeni Rakı Yeni Seri 35cl', 'en' => 'Yeni Raki New Series 35cl'],
                'description' => ['tr' => 'Meyhane klasiği; yaş üzüm suması ve anasonun mükemmel uyumu.', 'en' => 'The tavern classic; perfect harmony of fresh grape suma and aniseed.'],
                'price' => 1200, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 720,
                'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Beylerbeyi Göbek 70cl', 'en' => 'Beylerbeyi Gobek Raki 70cl'],
                'description' => ['tr' => '%100 yaş üzüm sumasından, 3 kez distile edilmiş premium göbek rakısı.', 'en' => 'Triple-distilled premium Raki from 100% fresh grapes, 70cl bottle.'],
                'price' => 2400, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 1440,
                'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ],
            [
                'name' => ['tr' => 'Tekirdağ Altın Seri 35cl', 'en' => 'Tekirdag Gold Series 35cl'],
                'description' => ['tr' => 'Meşe fıçılarda dinlendirilmiş altın sarısı yumuşak içimli seri.', 'en' => 'Gold series raki aged in oak barrels for smooth taste, 35cl bottle.'],
                'price' => 1350, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 750,
                'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ]
        ]);

        $catSaraplar = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Wines', 'tr' => 'Şaraplar'],
            'slug' => ['en' => 'wines', 'tr' => 'saraplar'],
            'order_column' => 2,
            'is_active' => true
        ]);
        $this->seedGroupItems($catSaraplar->id, [
            [
                'name' => ['tr' => 'Likya Patara Kırmızı 75cl', 'en' => 'Likya Patara Red 75cl'],
                'description' => ['tr' => 'Kaş yöresinin Likya bağlarından gelen zengin aromalı gövdeli kırmızı şarap.', 'en' => 'Richly aromatic full-bodied red wine from local Likya vineyards, 75cl.'],
                'price' => 1800, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 620,
                'allergen_info' => ['tr' => 'Kükürt Dioksit / Sülfitler', 'en' => 'Sulfur Dioxide / Sulfites']
            ],
            [
                'name' => ['tr' => 'Likya Patara Beyaz 75cl', 'en' => 'Likya Patara White 75cl'],
                'description' => ['tr' => 'Serinletici asiditesiyle deniz ürünleri ve mezelere eşlik eden yerel beyaz şarap.', 'en' => 'Refreshing local white wine, perfect companion to seafood and mezze, 75cl.'],
                'price' => 1800, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => true, 'calories' => 600,
                'allergen_info' => ['tr' => 'Kükürt Dioksit / Sülfitler', 'en' => 'Sulfur Dioxide / Sulfites']
            ]
        ]);

        $catAlkolsuz = Category::create([
            'parent_id' => $drinkCat->id,
            'name' => ['en' => 'Soft Drinks', 'tr' => 'Alkolsüz İçecekler'],
            'slug' => ['en' => 'soft-drinks', 'tr' => 'alkolsuz-icecekler'],
            'order_column' => 3,
            'is_active' => true
        ]);
        $this->seedGroupItems($catAlkolsuz->id, [
            [
                'name' => ['tr' => 'Şalgam Suyu Acılı 33cl', 'en' => 'Spicy Turnip Juice 33cl'],
                'description' => ['tr' => 'Doğal fermente acılı mor havuç suyu, rakiyle mükemmel gider.', 'en' => 'Naturally fermented spicy purple carrot juice, perfect with raki.'],
                'price' => 90, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 25,
                'allergen_info' => ['tr' => 'Gluten (Arpa Mayası)', 'en' => 'Gluten (Barley Yeast)']
            ],
            [
                'name' => ['tr' => 'Maden Suyu', 'en' => 'Mineral Water'],
                'description' => ['tr' => 'Doğal zengin mineralli kapaklı soda.', 'en' => 'Naturally carbonated rich mineral water.'],
                'price' => 80, 'is_vegan' => true, 'is_vegetarian' => true, 'contains_alcohol' => false, 'calories' => 0,
                'allergen_info' => ['tr' => 'Yok', 'en' => 'None']
            ]
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
                'is_vegan' => $item['is_vegan'],
                'is_vegetarian' => $item['is_vegetarian'],
                'contains_alcohol' => $item['contains_alcohol'],
                'calories' => $item['calories'],
                'allergen_info' => $item['allergen_info'],
                'is_active' => true,
                'order_column' => $idx + 1,
            ]);
        }
    }
}
