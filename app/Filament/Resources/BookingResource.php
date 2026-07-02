<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $modelLabel = 'Rezervasyon';
    protected static ?string $pluralModelLabel = 'Rezervasyonlar';
    protected static ?string $navigationGroup = 'Rezervasyon Yönetimi';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Müşteri ve Masa Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Müşteri Ad Soyad')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon Numarası')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('E-posta Adresi')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('booking_date')
                            ->label('Rezervasyon Tarihi')
                            ->required()
                            ->default(now()),
                        Forms\Components\TextInput::make('booking_time')
                            ->label('Saat Slotu')
                            ->required()
                            ->placeholder('örn: 19:30')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('party_size')
                            ->label('Kişi Sayısı')
                            ->numeric()
                            ->required()
                            ->default(2),
                        Forms\Components\Select::make('seating_area')
                            ->label('Tercih Edilen Alan')
                            ->options([
                                'garden' => 'Bahçe',
                                'terrace' => 'Teras',
                                'outdoor' => 'Dış Mekan (Eski)',
                                'indoor' => 'İç Mekan (Eski)',
                            ])
                            ->required()
                            ->default('garden'),
                        Forms\Components\Select::make('status')
                            ->label('Rezervasyon Durumu')
                            ->options([
                                'pending' => 'Beklemede',
                                'approved' => 'Onaylandı',
                                'cancelled' => 'İptal Edildi',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Özel Notlar')
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->rows(3),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad Soyad')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tarih')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking_time')
                    ->label('Saat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('party_size')
                    ->label('Kişi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('seating_area')
                    ->label('Alan')
                    ->options([
                        'garden' => 'Bahçe',
                        'terrace' => 'Teras',
                        'outdoor' => 'Dış Mekan',
                        'indoor' => 'İç Mekan',
                    ]),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Durum')
                    ->options([
                        'pending' => 'Beklemede',
                        'approved' => 'Onaylandı',
                        'cancelled' => 'İptal Edildi',
                    ])
                    ->selectablePlaceholder(false),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Kayıt Tarihi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('booking_date', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Rezervasyon Durumu')
                    ->options([
                        'pending' => 'Beklemede',
                        'approved' => 'Onaylandı',
                        'cancelled' => 'İptal Edildi',
                    ]),
                Tables\Filters\SelectFilter::make('seating_area')
                    ->label('Alan')
                    ->options([
                        'outdoor' => 'Dış Mekan',
                        'garden' => 'Bahçe',
                        'indoor' => 'İç Mekan',
                    ]),
                Tables\Filters\Filter::make('booking_date')
                    ->form([
                        Forms\Components\DatePicker::make('date')
                            ->label('Tarihe Göre Filtrele'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('booking_date', '=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
