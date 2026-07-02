<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularMenuItems extends BaseWidget
{
    protected static ?string $heading = 'En Çok Beğenilen Menü Öğeleri';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\MenuItem::with('category')
                    ->where('likes_count', '>', 0)
                    ->whereHas('category', function ($query) {
                        $query->where('name', 'not like', '%drink%')
                              ->where('name', 'not like', '%içecek%')
                              ->where('name', 'not like', '%wine%')
                              ->where('name', 'not like', '%şarap%')
                              ->where('name', 'not like', '%kokteyl%');
                    })
                    ->orderByDesc('likes_count')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Görsel')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Öğe Adı')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori'),
                Tables\Columns\ViewColumn::make('likes_count')
                    ->label('Toplam Beğeni')
                    ->sortable()
                    ->view('filament.tables.columns.editable-likes'),
            ]);
    }
}
