<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Forms\Components\FileUpload;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;

class ListGalleryImages extends ListRecords
{
    use Translatable;
    protected static string $resource = GalleryImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\Action::make('upload')
                ->label('Görsel Yükle')
                ->icon('heroicon-m-arrow-up-tray')
                ->color('primary')
                ->form([
                    FileUpload::make('images')
                        ->label('Görselleri Sürükle Bırak')
                        ->multiple()
                        ->image()
                        ->directory('gallery')
                        ->disk('public')
                        ->preserveFilenames()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('1200')
                        ->imageResizeTargetHeight('1200')
                        ->required(),
                ])
                ->action(function (array $data) {
                    foreach ($data['images'] as $imagePath) {
                        $fullPath = Storage::disk('public')->path($imagePath);
                        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                        
                        $newPath = $imagePath;
                        $image = null;

                        if (in_array($extension, ['jpg', 'jpeg'])) {
                            $image = @imagecreatefromjpeg($fullPath);
                        } elseif ($extension === 'png') {
                            $image = @imagecreatefrompng($fullPath);
                            if ($image) {
                                imagepalettetotruecolor($image);
                                imagealphablending($image, true);
                                imagesavealpha($image, true);
                            }
                        }

                        // If opened successfully, convert to highly compressed WEBP
                        if ($image) {
                            $newFilename = pathinfo($fullPath, PATHINFO_FILENAME) . '.webp';
                            $newPath = 'gallery/' . $newFilename;
                            $newFullPath = Storage::disk('public')->path($newPath);
                            
                            // Filament resizes before upload, so just compress & convert
                            imagewebp($image, $newFullPath, 60);
                            imagedestroy($image);
                            
                            // Try to delete original if a new file was created
                            if ($imagePath !== $newPath) {
                                @unlink($fullPath);
                            }
                        }

                        GalleryImage::create([
                            'image' => $newPath,
                            'title' => ['tr' => null, 'en' => null],
                            'alt_text' => ['tr' => null, 'en' => null],
                            'is_active' => true,
                            'order_column' => 0,
                        ]);
                    }
                })
                ->modalHeading('Görsel Yükle')
                ->modalDescription('Buradan çoklu olarak görsel yükleyebilirsiniz. Kaydedildiğinde doğrudan galeriye eklenecektir.')
                ->modalSubmitActionLabel('Yükle'),
            Actions\CreateAction::make(),
        ];
    }
}
