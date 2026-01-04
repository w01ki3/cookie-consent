<?php

namespace w01ki3\CookieConsent;

use Illuminate\Support\ServiceProvider;

class CookieConsentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerResources();
        if ($this->app->runningInConsole()) {
            $this->app->register(AssetsServiceProvider::class);

            $this->registerPublishing();
            $migrationFileName = 'create_cookie_consent_logs_table.php';
            if (empty(glob(database_path('migrations/*_' . $migrationFileName)))) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/' . $migrationFileName => database_path('migrations/' . date('Y_m_d_His') . '_' . $migrationFileName),
                ], 'migrations');
            }
        }
    }

    private function registerPublishing(): void
    {
        $this->publishes($this->getPublishMappings(), 'cookie-consent');
    }

    protected function getPublishMappings(): array
    {
        $langSource = __DIR__ . '/../resources/lang';

        $publish = [
            __DIR__ . '/config/cookie-consent.php' => config_path('cookie-consent.php'),
        ];

        if (is_dir($langSource)) {
            foreach (glob($langSource . '/*', GLOB_ONLYDIR) as $localeDir) {
                $locale = basename($localeDir);
                $file = $localeDir . '/cookie-consent.php';
                if (file_exists($file)) {
                    $publish[$file] = resource_path("lang/{$locale}/cookie-consent.php");
                }
            }
        }

        return $publish;
    }

    private function registerResources(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/cookie-consent.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cookie-consent');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cookie-consent');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/cookie-consent.php', 'cookie-consent');

        $this->app->singleton('CookieConsent', function ($app) {
            return new CookieConsent($app['session'], $app['config']);
        });
    }
}
