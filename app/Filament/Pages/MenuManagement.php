<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MenuManagement extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static string $view = 'filament.pages.menu-management';

    protected static ?string $navigationLabel = 'Menü Yönetimi (Kanban)';

    protected static ?string $title = 'Menü Yönetimi (Kanban)';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Menü';
}
