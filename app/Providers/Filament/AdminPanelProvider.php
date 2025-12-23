<?php

namespace App\Providers\Filament;

use Filament\Panel;
use App\Models\User;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\SalesChart;
use Illuminate\Support\Facades\Auth;
use Filament\Navigation\NavigationItem;

// --- TAMBAHKAN USE STATEMENT UNTUK WIDGET BARU ---
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\EventSalesTable;
use Filament\Http\Middleware\Authenticate;

use App\Filament\Widgets\SalesStatsOverview;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            // ->login()
            ->brandLogo(new HtmlString(view('filament.app-logo')->render()))
            ->brandName('PD-dig')
            ->favicon(asset('img/Icon-PD.png'))
            // ->topNavigation()
            // --- PERUBAHAN DI SINI (USER MENU) ---
            ->userMenuItems([
                MenuItem::make()
                    ->label('Edit Profil')
                    ->url(fn(): string => route('profile.edit')) // Arahkan ke route Breeze
                    ->icon('heroicon-o-user-circle'),
                // Menu 'Settings' sudah dihapus
            ])
            // -------------------------------------
            ->globalSearch(false)
            ->colors([
                'primary' => Color::Amber,
                // 'primary' => Color::Red,
                'gray' => Color::Slate,
                'info' => Color::Blue,
                'success' => Color::Green,
                // 'warning' => Color::Amber,
                'danger' => Color::Rose,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
                SalesStatsOverview::class,
                EventSalesTable::class,
            ])
            ->navigationItems([
                NavigationItem::make('Halaman User')
                    ->url(fn() => route('home'))
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->group('Navigasi')
                    ->sort(999),
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
            ]);
    }
}
