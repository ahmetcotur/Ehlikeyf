<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
class CreateSetting extends CreateRecord
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $type = $data['type'];
        $isTranslatable = $data['group'] === 'seo' || in_array($data['key'], ['site_name', 'address']);
        
        if ($isTranslatable) {
            $trValue = match($type) {
                'color' => $data['value_color_tr'] ?? '',
                'image' => $data['value_image_tr'] ?? '',
                'images' => $data['value_images_tr'] ?? [],
                'boolean' => $data['value_boolean_tr'] ?? '',
                default => $data['value_tr'] ?? '',
            };

            $enValue = match($type) {
                'color' => $data['value_color_en'] ?? '',
                'image' => $data['value_image_en'] ?? '',
                'images' => $data['value_images_en'] ?? [],
                'boolean' => $data['value_boolean_en'] ?? '',
                default => $data['value_en'] ?? '',
            };

            $data['value'] = [
                'tr' => $trValue,
                'en' => $enValue,
            ];
        } else {
            $globalVal = match($type) {
                'color' => $data['value_color_global'] ?? '',
                'image' => $data['value_image_global'] ?? '',
                'images' => $data['value_images_global'] ?? [],
                'boolean' => $data['value_boolean_global'] ?? '',
                default => $data['value_global'] ?? '',
            };

            // Save for both locales to satisfy Spatie Translatable
            $data['value'] = [
                'tr' => $globalVal,
                'en' => $globalVal,
            ];
        }

        // Clean up temporary fields to avoid "Column not found" SQL errors
        unset($data['value_tr'], $data['value_color_tr'], $data['value_image_tr'], $data['value_images_tr'], $data['value_boolean_tr']);
        unset($data['value_en'], $data['value_color_en'], $data['value_image_en'], $data['value_images_en'], $data['value_boolean_en']);
        unset($data['value_global'], $data['value_color_global'], $data['value_image_global'], $data['value_images_global'], $data['value_boolean_global']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
    protected static string $resource = SettingResource::class;
}
