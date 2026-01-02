# cookie-consent
A GDPR-compliant cookie consent solution for Laravel applications with fully customizable cookie banners, granular consent control, and enterprise-grade compliance features.

1. Install the package via Composer:

```bash
composer require w01ki3/laravel-cookie-consent
```

2. Publish the package resources by running: (Normal publish)

```bash
php artisan vendor:publish --provider="w01ki3\CookieConsent\CookieConsentServiceProvider"
```

Include these components in your Blade templates:

1. Add styles in the `<head>` section:

```php
{!! CookieConsent::styles() !!}
```

2. Add scripts before closing `</body>`:

```php
{!! CookieConsent::scripts() !!}
```