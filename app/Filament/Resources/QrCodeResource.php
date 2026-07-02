<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QrCodeResource\Pages;
use App\Filament\Resources\QrCodeResource\RelationManagers;
use App\Models\QrCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QrCodeResource extends Resource
{
    protected static ?string $model = QrCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $modelLabel = 'QR Kod';
    protected static ?string $pluralModelLabel = 'QR Kodlar (Masa/Broşür)';
    protected static ?string $navigationGroup = 'Menü';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Section::make('QR Kod Detayları')
                            ->description('Masa, broşür veya sosyal medya için yönlendirilebilir QR kod tanımlayın.')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('QR Kod Tanımı (Örn: Masa 1, Giriş Kartı)')
                                    ->required()
                                    ->placeholder('Masa 12')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('target_url')
                                    ->label('Yönlendirilecek Sayfa / URL')
                                    ->required()
                                    ->placeholder('/menu?table=Masa-12')
                                    ->helperText('Site içi sayfalar için bağıl (örn: /menu?table=Masa-12 veya /menu), harici siteler için tam URL (örn: https://instagram.com/ehlikeyfkas) girin.')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('scans_count')
                                    ->label('Okunma Sayısı')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->visible(fn ($record) => $record !== null)
                                    ->numeric(),
                            ])
                            ->columnSpan(2),

                        Forms\Components\Section::make('QR Kod Önizleme')
                            ->description('Bu kodun çıktısını alıp masalara yerleştirebilirsiniz.')
                            ->schema([
                                Forms\Components\Placeholder::make('qr_code_preview')
                                    ->label('Canlı QR Kod')
                                    ->content(function ($record) {
                                        if (!$record) return 'QR kod oluşturulduktan sonra önizlenebilir.';
                                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode(route('qr.redirect', ['id' => $record->id]));
                                        return new \Illuminate\Support\HtmlString("
                                            <div class='flex flex-col items-center gap-4 bg-gray-50/50 p-4 rounded-xl border border-gray-100 shadow-sm max-w-[280px] mx-auto'>
                                                <img src='{$qrUrl}' alt='QR' class='w-44 h-44 border border-gray-200 p-2 bg-white rounded-lg' />
                                                <a href='{$qrUrl}' target='_blank' download='qr_{$record->id}.png' class='inline-flex items-center justify-center gap-2 w-full px-4 py-2 bg-primary-600 text-white rounded-lg text-xs font-semibold hover:bg-primary-700 transition shadow-sm'>
                                                    <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'></path></svg>
                                                    Yüksek Çözünürlüklü QR İndir
                                                </a>
                                            </div>
                                        ");
                                    })
                                    ->visible(fn ($record) => $record !== null),
                            ])
                            ->columnSpan(1),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('qr_preview')
                    ->label('QR Kod')
                    ->state(fn ($record) => "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode(route('qr.redirect', ['id' => $record->id])))
                    ->size(55),
                Tables\Columns\TextColumn::make('name')
                    ->label('QR Tanımı')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_url')
                    ->label('Yönlendirme Adresi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('scans_count')
                    ->label('Okunma Sayısı')
                    ->numeric()
                    ->alignCenter()
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('scans_count', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('İndir')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => "https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=" . urlencode(route('qr.redirect', ['id' => $record->id])))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListQrCodes::route('/'),
            'create' => Pages\CreateQrCode::route('/create'),
            'edit' => Pages\EditQrCode::route('/{record}/edit'),
        ];
    }
}
