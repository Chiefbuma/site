<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PowerBIDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static string $view = 'filament.pages.power-bi-dashboard';
    protected static ?string $title = 'Analytics Dashboard';
    protected static ?string $navigationLabel = 'Analytics Dashboard';
    protected static ?string $slug = 'analytics';

    public static function shouldRegisterNavigation(): bool
    {
        // Optional: Control if this page should appear in navigation
        return true;
    }

    public function getHeading(): string
    {
        return static::$title;
    }

    public function getSubheading(): ?string
    {
        return 'Key metrics and visualizations'; // Optional subtitle
    }
}