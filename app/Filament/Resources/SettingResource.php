<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $modelLabel = 'Ayar';
    protected static ?string $pluralModelLabel = 'Ayarlar';
    protected static ?string $navigationGroup = 'Site Ayarları';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ayar Detayları')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('key')
                                    ->label('Anahtar (Key)')
                                    ->required()
                                    ->disabled(fn ($operation) => $operation === 'edit')
                                    ->maxLength(255),
                                Forms\Components\Select::make('type')
                                    ->label('Tip')
                                    ->options([
                                        'text' => 'Metin',
                                        'image' => 'Görsel',
                                        'images' => 'Görsel Galerisi (Çoklu)',
                                        'color' => 'Renk',
                                        'boolean' => 'Evet / Hayır',
                                    ])
                                    ->required()
                                    ->disabled(fn ($operation) => $operation === 'edit')
                                    ->live(),
                                Forms\Components\Select::make('group')
                                    ->label('Grup')
                                    ->options([
                                        'general' => 'Genel',
                                        'contact' => 'İletişim',
                                        'branding' => 'Marka',
                                        'seo' => 'SEO',
                                    ])
                                    ->required(),
                            ]),
                        
                        Forms\Components\Tabs::make('Çeviriler')
                            ->visible(fn (Forms\Get $get) => $get('group') === 'seo' || $get('group') === 'contact' || in_array($get('key'), ['site_name', 'address']))
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('Türkçe')
                                    ->schema([
                                        Forms\Components\TextInput::make('value_tr')
                                            ->label('Değer (TR)')
                                            ->visible(fn (Forms\Get $get) => in_array($get('type'), ['text', '']))
                                            ->columnSpanFull(),
                                        Forms\Components\ColorPicker::make('value_color_tr')
                                            ->label('Renk Değeri (TR)')
                                            ->visible(fn (Forms\Get $get) => $get('type') === 'color')
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('value_image_tr')
                                            ->label('Görsel Değeri (TR)')
                                            ->image()
                                            ->directory('settings')
                                            ->visible(fn (Forms\Get $get) => $get('type') === 'image')
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('value_images_tr')
                                            ->label('Çoklu Görsel Galerisi (TR)')
                                            ->image()
                                            ->multiple()
                                            ->reorderable()
                                            ->directory('settings')
                                            ->visible(fn (Forms\Get $get) => $get('type') === 'images')
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('value_boolean_tr')
                                            ->label('Değer (TR)')
                                            ->options([
                                                '1' => 'Evet / True',
                                                '0' => 'Hayır / False',
                                            ])
                                            ->visible(fn (Forms\Get $get) => $get('type') === 'boolean')
                                            ->columnSpanFull(),
                                    ]),
                                Forms\Components\Tabs\Tab::make('English (İngilizce)')
                                    ->schema([
                                        Forms\Components\TextInput::make('value_en')
                                            ->label('Değer (EN)')
                                            ->visible(fn (Forms\Get $get) => in_array($get('type'), ['text', '']))
                                            ->columnSpanFull(),
                                        Forms\Components\ColorPicker::make('value_color_en')
                                            ->label('Renk Değeri (EN)')
                                            ->visible(fn (Forms\Get $get) => $get('type') === 'color')
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('value_image_en')
                                            ->label('Görsel Değeri (EN)')
                                            ->image()
                                            ->directory('settings')
                                            ->visible(fn (Forms\Get $get) => $get('type') === 'image')
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('value_images_en')
                                            ->label('Çoklu Görsel Galerisi (EN)')
                                            ->image()
                                            ->multiple()
                                            ->reorderable()
                                            ->directory('settings')
                                            ->visible(fn (Forms\Get $get) => $get('type') === 'images')
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('value_boolean_en')
                                            ->label('Değer (EN)')
                                            ->options([
                                                '1' => 'Evet / True',
                                                '0' => 'Hayır / False',
                                            ])
                                            ->visible(fn (Forms\Get $get) => $get('type') === 'boolean')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpanFull(),
                            
                        Forms\Components\Section::make('Evrensel Değer (Global)')
                            ->visible(fn (Forms\Get $get) => !($get('group') === 'seo' || in_array($get('key'), ['site_name', 'address'])))
                            ->schema([
                                Forms\Components\TextInput::make('value_global')
                                    ->label('Değer')
                                    ->visible(fn (Forms\Get $get) => in_array($get('type'), ['text', '']))
                                    ->columnSpanFull(),
                                Forms\Components\ColorPicker::make('value_color_global')
                                    ->label('Renk Değeri')
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'color')
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('value_image_global')
                                    ->label('Görsel Değeri')
                                    ->image()
                                    ->directory('settings')
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'image')
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('value_images_global')
                                    ->label('Çoklu Görsel Galerisi')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->directory('settings')
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'images')
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('value_boolean_global')
                                    ->label('Değer')
                                    ->options([
                                        '1' => 'Evet',
                                        '0' => 'Hayır',
                                    ])
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'boolean')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'branding' => 'primary',
                        'contact' => 'success',
                        'seo' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('key')
                    ->label('Anahtar')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\ImageColumn::make('image_preview')
                    ->label('Önizleme')
                    ->state(function ($record) {
                        try {
                            if (!in_array($record->type, ['image', 'images'])) return null;
                            
                            $val = $record->value;
                            if (is_array($val)) $val = reset($val);
                            
                            if ($record->type === 'image') {
                                return is_string($val) && $val ? $val : null;
                            }
                            
                            if ($record->type === 'images') {
                                if (is_string($val) && str_starts_with($val, '[')) {
                                    $val = json_decode($val, true);
                                }
                                if (is_array($val)) {
                                    $firstImg = reset($val);
                                    return is_string($firstImg) && $firstImg ? $firstImg : null;
                                }
                            }
                            return null;
                        } catch (\Throwable $e) {
                            return null;
                        }
                    })
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(asset('images/logo.png')),
                Tables\Columns\TextColumn::make('value')
                    ->label('Değer')
                    ->limit(30)
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        try {
                            if ($record->type === 'image') return '';
                            if ($record->type === 'images') {
                                $val = is_array($record->value) ? ($record->value[app()->getLocale()] ?? reset($record->value)) : $record->value;
                                if (is_string($val) && str_starts_with($val, '[')) $val = json_decode($val, true);
                                $count = is_array($val) ? count($val) : 0;
                                return "[$count Görsel]";
                            }
                            
                            // Handle manual array translations
                            if (is_array($state)) {
                                return $state[app()->getLocale()] ?? reset($state);
                            }
                            
                            return is_string($state) ? $state : json_encode($state);
                        } catch (\Throwable $e) {
                            return 'Hata';
                        }
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Grup')
                    ->options([
                        'general' => 'Genel',
                        'contact' => 'İletişim',
                        'branding' => 'Marka',
                        'seo' => 'SEO',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
