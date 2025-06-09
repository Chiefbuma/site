<?php

namespace App\Providers\Filament;

use Filament\Contracts\Plugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Pxlrbt\FilamentExcel\FilamentExcelPlugin;
use Filament\Enums\ThemeMode;
use App\Filament\Widgets\TotalPatientsDonutChart;
use App\Filament\Widgets\AgeDistributionDonutChart;
use App\Filament\Widgets\GenderDistributionDonutChart;
use App\Filament\Widgets\StatusDistributionDonutChart;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;



class HomePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('home')
            ->path('home')
            ->login()
            ->darkMode(true) // Enable dark mode
            ->defaultThemeMode(ThemeMode::Dark) // Default to dark mode
            
         
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
               
                AgeDistributionDonutChart::class,
                TotalPatientsDonutChart::class,
                statusDistributionDonutChart::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
             
                FilamentApexChartsPlugin::make()
                
            ])

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            
         ->plugins([
    \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
    FilamentApexChartsPlugin::make()
         ]);

    }
}