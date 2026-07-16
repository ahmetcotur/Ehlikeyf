<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('categories') || ! Schema::hasTable('menu_items')) {
            return;
        }

        $menu = [
            'Mezeler' => [
                'parent' => ['enSlug' => 'meze-menu', 'enName' => 'Meze Menu', 'trSlug' => 'meze-menusu', 'trName' => 'Meze Menüsü'],
                'category' => ['enName' => 'Daily Cold Mezes', 'trName' => 'Günlük Soğuk Mezeler', 'enSlug' => 'daily-cold-mezes', 'trSlug' => 'gunluk-soguk-mezeler', 'order' => 1],
                'items' => [
                    ['name' => 'Ada Güzeli', 'price' => 445],
                    ['name' => 'Ahtapot Salata', 'price' => 650],
                    ['name' => 'Al Yanak', 'price' => 435],
                    ['name' => 'Antep Ezme', 'price' => 425],
                    ['name' => 'Antibiyotik', 'price' => 450],
                    ['name' => 'Atina', 'price' => 480],
                    ['name' => 'Babagannuş', 'price' => 425],
                    ['name' => 'Balon Biber', 'price' => 565],
                    ['name' => 'Cumhuriyet', 'price' => 430],
                    ['name' => 'Çıtır Bahçe', 'price' => 425],
                    ['name' => 'Deniz Börülcesi', 'price' => 455],
                    ['name' => 'Deniz Ürünleri Salata', 'price' => 600],
                    ['name' => 'Ege Atomu', 'price' => 425],
                    ['name' => 'Ehli Keyf Meze', 'price' => 445],
                    ['name' => 'Enginar Dolma', 'price' => 440],
                    ['name' => 'Enginar Kalbi', 'price' => 490],
                    ['name' => 'Fava', 'price' => 425],
                    ['name' => 'Girit Ezme', 'price' => 465],
                    ['name' => 'Hardallı Levrek', 'price' => 600],
                    ['name' => 'Havuç Tarator', 'price' => 425],
                    ['name' => 'Humus', 'price' => 435],
                    ['name' => 'Pastırmalı Humus', 'price' => 600],
                    ['name' => 'Kabak Çiçeği Dolması', 'price' => 450],
                    ['name' => 'Karpuz Dilim', 'price' => 150],
                    ['name' => 'Kavun Dilim', 'price' => 150],
                    ['name' => 'Köpoğlu', 'price' => 425],
                    ['name' => 'Kuru Cacık', 'price' => 425],
                    ['name' => 'Kuru Domates', 'price' => 430],
                    ['name' => 'Levrek Marin', 'price' => 600],
                    ['name' => 'Ot Kavurma', 'price' => 500],
                    ['name' => 'Paçanga Böreği', 'price' => 600],
                    ['name' => 'Pancar', 'price' => 425],
                    ['name' => 'Patatesli Atom', 'price' => 545],
                    ['name' => 'Şakşuka', 'price' => 440],
                    ['name' => 'Vişne Soslu Yaprak Sarma', 'price' => 460],
                    ['name' => 'Yunan Cacığı', 'price' => 425],
                    ['name' => 'Zeytin Salatası', 'price' => 425],
                    ['name' => 'Zümrüt', 'price' => 525],
                    ['name' => 'Ezine Dilim', 'price' => 225],
                    ['name' => 'Kaya Koruğu', 'price' => 425],
                ],
            ],
            'Başlangıçlar' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Starters', 'trName' => 'Başlangıçlar', 'enSlug' => 'starters', 'trSlug' => 'baslangiclar', 'order' => 1],
                'items' => [
                    ['name' => 'Balık Çorbası', 'price' => 600],
                    ['name' => 'Domates Çorbası', 'price' => 450],
                ],
            ],
            'Ara Sıcaklar' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Warm Appetizers', 'trName' => 'Ara Sıcaklar', 'enSlug' => 'warm-appetizers', 'trSlug' => 'ara-sicaklar', 'order' => 2],
                'items' => [
                    ['name' => 'Kalamar Tava', 'price' => 985],
                    ['name' => 'İspanyol Karides (Acılı)', 'price' => 1050],
                    ['name' => 'Tereyağlı Sarımsaklı Karides', 'price' => 995],
                    ['name' => 'Kalamar Izgara', 'price' => 1150],
                    ['name' => 'Midye Tava', 'price' => 975],
                    ['name' => 'Ahtapot Izgara', 'price' => 1350],
                    ['name' => 'Kalamar Dolma', 'price' => 1300],
                    ['name' => 'Levrek Simit', 'price' => 800],
                    ['name' => 'Sarımsaklı Kaşarlı Mantar', 'price' => 700],
                    ['name' => 'Kızarmış Peynir', 'price' => 475],
                    ['name' => 'Paçanga Böreği', 'price' => 650],
                    ['name' => 'Sigara Böreği', 'price' => 600],
                    ['name' => 'Patates Kızartması', 'price' => 450],
                ],
            ],
            'Salatalar' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Salads', 'trName' => 'Salatalar', 'enSlug' => 'salads', 'trSlug' => 'salatalar', 'order' => 9],
                'items' => [
                    ['name' => 'Ehl-i Keyf Salata', 'price' => 650],
                    ['name' => 'Roka Salata', 'price' => 525],
                    ['name' => 'Çoban Salata', 'price' => 510],
                    ['name' => 'Yeşil Salata', 'price' => 525],
                    ['name' => 'Gavurdağı Salata', 'price' => 550],
                    ['name' => 'Hellim Roka', 'price' => 600],
                ],
            ],
            'Makarnalar' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Pastas', 'trName' => 'Makarnalar', 'enSlug' => 'pastas', 'trSlug' => 'makarnalar', 'order' => 5],
                'items' => [
                    ['name' => 'Kıymalı Penne', 'price' => 825],
                    ['name' => 'Kremalı Tavuk Penne', 'price' => 850],
                    ['name' => 'Fesleğen Soslu Penne', 'price' => 810],
                    ['name' => 'Deniz Ürünleri Penne', 'price' => 1250],
                ],
            ],
            'Güveçler' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Casseroles', 'trName' => 'Güveçler', 'enSlug' => 'casseroles', 'trSlug' => 'guvecler', 'order' => 7],
                'items' => [
                    ['name' => 'Tavuk Güveç', 'price' => 925],
                    ['name' => 'Ahtapot Güveç', 'price' => 1325],
                    ['name' => 'Karides Güveç', 'price' => 1250],
                    ['name' => 'Kuzu Güveç', 'price' => 1260],
                    ['name' => 'Deniz Ürünleri Güveç', 'price' => 1530],
                    ['name' => 'Sebze Güveç', 'price' => 825],
                ],
            ],
            'Deniz Ürünleri' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Seafood', 'trName' => 'Deniz Ürünleri', 'enSlug' => 'seafood', 'trSlug' => 'deniz-urunleri', 'order' => 8],
                'items' => [
                    ['name' => 'Ehl-i Keyf Deniz Tepsisi (2 Kişilik)', 'price' => 5750],
                    ['name' => 'Paella', 'price' => 1600],
                    ['name' => 'Çupra Izgara', 'price' => 985],
                    ['name' => 'Levrek Izgara', 'price' => 1025],
                    ['name' => 'Kılıç Şiş Izgara', 'price' => 1250],
                    ['name' => 'Dil Tava', 'price' => 1040],
                    ['name' => 'Jumbo Karides Izgara', 'price' => 1300],
                    ['name' => 'Somon Izgara', 'price' => 1125],
                    ['name' => 'Günlük Deniz Balıkları', 'price' => null],
                ],
            ],
            'Izgaralar' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Grills', 'trName' => 'Izgaralar', 'enSlug' => 'grills', 'trSlug' => 'izgaralar', 'order' => 6],
                'items' => [
                    ['name' => 'Full Karışık Izgara (2 Kişilik)', 'price' => 6190],
                    ['name' => 'Pirzola', 'price' => 1550],
                    ['name' => 'Kuzu Şiş', 'price' => 1200],
                    ['name' => 'Tavuk Şiş', 'price' => 800],
                    ['name' => 'Izgara Köfte', 'price' => 900],
                    ['name' => 'Izgara Bonfile', 'price' => 1650],
                    ['name' => 'Karışık Izgara', 'price' => 1550],
                ],
            ],
            'Bonfileler' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Steaks', 'trName' => 'Bonfileler', 'enSlug' => 'steaks', 'trSlug' => 'bonfileler', 'order' => 3],
                'items' => [
                    ['name' => 'Acılı Bonfile', 'price' => 1750],
                    ['name' => 'Mantar Soslu Bonfile', 'price' => 1850],
                    ['name' => 'Sade Bonfile', 'price' => 1650],
                    ['name' => 'Fajita', 'price' => 1700],
                ],
            ],
            'Tavuk Yemekleri' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Chicken Dishes', 'trName' => 'Tavuk Yemekleri', 'enSlug' => 'chicken-dishes', 'trSlug' => 'tavuk-yemekleri', 'order' => 4],
                'items' => [
                    ['name' => 'Mantar Soslu Tavuk', 'price' => 925],
                    ['name' => 'Tavuk Köri', 'price' => 915],
                    ['name' => 'Tavuk Şinitzel', 'price' => 865],
                ],
            ],
            'Tatlılar' => [
                'parent' => ['enSlug' => 'food-menu', 'enName' => 'Food Menu', 'trSlug' => 'yemek-menusu', 'trName' => 'Yemek Menüsü'],
                'category' => ['enName' => 'Desserts', 'trName' => 'Tatlılar', 'enSlug' => 'desserts', 'trSlug' => 'tatlilar', 'order' => 10],
                'items' => [
                    ['name' => 'Fırında Helva', 'price' => 550],
                    ['name' => 'Doğal Tava Dondurma', 'price' => 300],
                    ['name' => 'Dondurmalı İncir Kavurması', 'price' => 650],
                    ['name' => 'Dondurmalı İrmik Helvası', 'price' => 680],
                    ['name' => 'Makara Tatlısı', 'price' => 500],
                ],
            ],
        ];

        $aliases = [
            'Full Karışık Izgara (2 Kişilik)' => ['Ful Karışık Izgara (2 Kişilik)'],
            'Tereyağlı Sarımsaklı Karides' => ['Tereyağlı Sarımsaklı Karides Tava'],
            'Paçanga Böreği' => ['Paçanga Böreği (Pastırma - Kaşar)'],
            'Hellim Roka' => ['Hellim Roka Salata'],
            'Fırında Helva' => ['Fırında Tahin Helvası'],
        ];

        $now = now();
        $existingItems = DB::table('menu_items')->get()->keyBy(function ($item) {
            $name = json_decode($item->name, true) ?: [];
            return $this->normalize($name['tr'] ?? '');
        });

        foreach ($menu as $section) {
            $parentId = $this->ensureCategory(null, $section['parent']['trName'], $section['parent']['enName'], $section['parent']['trSlug'], $section['parent']['enSlug'], $now);
            $categoryId = $this->ensureCategory($parentId, $section['category']['trName'], $section['category']['enName'], $section['category']['trSlug'], $section['category']['enSlug'], $now, $section['category']['order']);

            DB::table('menu_items')->where('category_id', $categoryId)->delete();

            foreach ($section['items'] as $index => $item) {
                $template = $this->findTemplate($existingItems, $item['name'], $aliases);
                $name = $template ? (json_decode($template->name, true) ?: []) : ['tr' => $item['name'], 'en' => $item['name']];
                $name['tr'] = $item['name'];

                $description = $template ? $template->description : null;
                if ($item['price'] === null) {
                    $description = json_encode([
                        'tr' => 'Mevsimine göre günlük taze balıklar. Kilo ile fiyatlandırılır.',
                        'en' => 'Daily fresh seasonal fish options. Priced by weight (kg).',
                    ], JSON_UNESCAPED_UNICODE);
                }

                DB::table('menu_items')->insert([
                    'category_id' => $categoryId,
                    'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
                    'slug' => json_encode(['tr' => Str::slug($item['name']), 'en' => Str::slug($name['en'] ?? $item['name'])], JSON_UNESCAPED_UNICODE),
                    'description' => $description,
                    'price' => $item['price'],
                    'image' => $template->image ?? null,
                    'is_featured' => $template->is_featured ?? false,
                    'is_active' => true,
                    'order_column' => $index + 1,
                    'likes_count' => $template->likes_count ?? 0,
                    'is_vegan' => $template->is_vegan ?? false,
                    'is_vegetarian' => $template->is_vegetarian ?? false,
                    'contains_alcohol' => $template->contains_alcohol ?? false,
                    'calories' => $template->calories ?? null,
                    'allergen_info' => $template->allergen_info ?? null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Menu price/content updates are intentionally not rolled back.
    }

    private function ensureCategory(?int $parentId, string $trName, string $enName, string $trSlug, string $enSlug, $now, int $order = 0): int
    {
        $query = DB::table('categories')
            ->where(function ($query) use ($trSlug, $enSlug, $trName) {
                $query->where('slug->tr', $trSlug)
                    ->orWhere('slug->en', $enSlug)
                    ->orWhere('name->tr', $trName);
            });

        if ($parentId === null) {
            $query->whereNull('parent_id');
        }

        $category = $query->first();

        if ($parentId === null && $order === 0) {
            $order = match ($trSlug) {
                'meze-menusu' => 1,
                'yemek-menusu' => 2,
                'icecek-menusu' => 3,
                default => 0,
            };
        }

        $payload = [
            'parent_id' => $parentId,
            'name' => json_encode(['tr' => $trName, 'en' => $enName], JSON_UNESCAPED_UNICODE),
            'slug' => json_encode(['tr' => $trSlug, 'en' => $enSlug], JSON_UNESCAPED_UNICODE),
            'is_active' => true,
            'order_column' => $order,
            'updated_at' => $now,
        ];

        if ($category) {
            DB::table('categories')->where('id', $category->id)->update($payload);
            return $category->id;
        }

        $payload['created_at'] = $now;
        return (int) DB::table('categories')->insertGetId($payload);
    }

    private function findTemplate($existingItems, string $name, array $aliases): ?object
    {
        $keys = [$name, ...($aliases[$name] ?? [])];
        foreach ($keys as $key) {
            $template = $existingItems->get($this->normalize($key));
            if ($template) {
                return $template;
            }
        }
        return null;
    }

    private function normalize(string $value): string
    {
        return Str::of($value)->lower()->ascii()->replaceMatches('/[^a-z0-9]+/', ' ')->squish()->toString();
    }
};
