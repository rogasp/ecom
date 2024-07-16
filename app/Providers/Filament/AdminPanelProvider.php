<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Home;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CityResource;
use App\Filament\Resources\CountryResource;
use App\Filament\Resources\CurrencyResource;
use App\Filament\Resources\NavigationResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\UserResource;
use Croustibat\FilamentJobsMonitor\FilamentJobsMonitorPlugin;
use Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin;
use TomatoPHP\FilamentTranslations\FilamentTranslationsSwitcherPlugin;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications()
            ->databaseNotificationsPolling('6000s')
            ->colors([
                'primary' => Color::Cyan,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('Dashboard')->items([
                        ...Home::getNavigationItems(),
                    ]),
                    NavigationGroup::make(__('Orders'))->items([
                        ...OrderResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Products')->items([
                        ...CategoryResource::getNavigationItems(),
                        ...ProductResource::getNavigationItems(),

                    ]),
                    NavigationGroup::make('Content')->items([
                        ...CountryResource::getNavigationItems(),
                        ...CityResource::getNavigationItems(),
                        ...CurrencyResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Users & Roles')->items([
                        ...UserResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Settings')->items([
                        ...NavigationResource::getNavigationItems(),
                        ...TranslationResource::getNavigationItems(),
                        ...QueueMonitorResource::getNavigationItems(),
                    ])
                ]);
            })
            ->plugins([
                FilamentTranslationsPlugin::make()
                    ->allowClearTranslations()
                    #->allowGoogleTranslateScan()
                    ->allowGPTScan(),
                FilamentTranslationsSwitcherPlugin::make(),
                FilamentJobsMonitorPlugin::make()
                ->enableNavigation()
                ->enablePruning(),
                ThemesPlugin::make(),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
                SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
