<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\GalleryImage;

class MigrateGalleryImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gallery:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates legacy public gallery images to storage, converts them to low-file-size WebP format, and updates the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $publicDir = public_path('images/gallery');
        $storageDir = storage_path('app/public/gallery');

        // Create the public/gallery storage directory if it doesn't exist
        if (!File::exists($storageDir)) {
            File::makeDirectory($storageDir, 0775, true);
        }

        if (!File::exists($publicDir)) {
            $this->error("Original public gallery directory not found at: {$publicDir}. Nothing to migrate.");
            return;
        }

        $files = File::files($publicDir);
        $this->info("Found " . count($files) . " images to migrate and optimize.");

        $successCount = 0;

        foreach ($files as $file) {
            $originalName = $file->getFilename();
            $extension = strtolower($file->getExtension());
            $basename = pathinfo($originalName, PATHINFO_FILENAME);
            
            $sourcePath = $file->getRealPath();
            
            // We want to generate a WebP version
            $newFilename = $basename . '.webp';
            $destPath = $storageDir . '/' . $newFilename;
            $dbPath = 'gallery/' . $newFilename;

            $this->info("Processing {$originalName}...");

            $image = null;
            
            // Use PHP Native GD library to convert images to highly optimized internal WEBP format
            if (in_array($extension, ['jpg', 'jpeg'])) {
                $image = @imagecreatefromjpeg($sourcePath);
            } elseif ($extension === 'png') {
                $image = @imagecreatefrompng($sourcePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
            } elseif ($extension === 'webp') {
                $image = @imagecreatefromwebp($sourcePath);
            }

            if ($image) {
                // Get current dimensions
                $width = imagesx($image);
                $height = imagesy($image);
                
                // If it's larger than 1200px (like huge 4000px photos), resize it down to save huge amounts of memory
                $maxWidth = 1200;
                $maxHeight = 1200;
                
                if ($width > $maxWidth || $height > $maxHeight) {
                    $ratio = min($maxWidth / $width, $maxHeight / $height);
                    $newWidth = (int) ($width * $ratio);
                    $newHeight = (int) ($height * $ratio);
                    
                    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                    if ($extension === 'png') {
                        imagealphablending($resizedImage, false);
                        imagesavealpha($resizedImage, true);
                        $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                        imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
                    }
                    
                    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    imagedestroy($image);
                    $image = $resizedImage;
                    $this->line("   -> Resized from {$width}x{$height} to {$newWidth}x{$newHeight}");
                }

                // Compress and convert to WEBP with a quality of 60% (highly compressed, visually similar)
                imagewebp($image, $destPath, 60);
                imagedestroy($image);
                $this->info("   -> Converted to low-size WebP ({$newFilename})");
                $successCount++;
            } else {
                // Fallback: if GD fails for some reason, just strictly copy it
                File::copy($sourcePath, $storageDir . '/' . $originalName);
                $dbPath = 'gallery/' . $originalName;
                $this->line("   -> GD failed. Copied original file {$originalName} directly.");
            }

            // Look for this original image in the DB and patch its path to point to the new WEBP format
            $oldDbPath = 'gallery/' . $originalName;
            
            // Update records
            GalleryImage::where('image', $oldDbPath)
                ->orWhere('image', $originalName)
                ->update(['image' => $dbPath]);
        }

        $this->info("");
        $this->info("✅ Successfully migrated and optimized {$successCount} images!");
    }
}
