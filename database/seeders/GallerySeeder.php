<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $files = File::files(public_path('images/gallery'));
        $order = 1;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $title = explode('.', $filename)[0];

            $image = GalleryImage::create([
                'image' => 'gallery/' . $filename,
                'order_column' => $order++,
                'is_active' => true,
            ]);

            $image->setTranslation('title', 'en', 'Gallery Image ' . $order);
            $image->setTranslation('title', 'tr', 'Galeri Görseli ' . $order);
            $image->setTranslation('alt_text', 'en', 'Elia Restaurant ' . $title);
            $image->setTranslation('alt_text', 'tr', 'Elia Restaurant ' . $title);
            $image->save();
        }
    }
}
