
# cookie-consent

*Take control of the cookie policy warning for your Laravel projects with this package.<br>
Record in the database whether the user accepts or rejects the cookie policy.<br>
User activity is recorded along with masked IP address information.<br>
You can customize it.<br>
You can also add different language options. (Currently, Turkish and English are included in the package.)*

***Installation steps***

**1**. Install the package via Composer:
```bash
composer require w01ki3/cookie-consent
```
**2**. Publish the package resources
```bash
php artisan vendor:publish --provider="w01ki3\CookieConsent\CookieConsentServiceProvider"
```
**3**. Create a table to transfer the records to the database.
```bash
php artisan migrate
```
**4**. If you don't have a csrf token, please add it to the page.
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```
**5**. Add styles in the `<head>` section:
```php
{!! CookieConsent::styles() !!}
```
**6**. Add scripts before closing `</body>`:
```php
{!! CookieConsent::scripts() !!}
```
*Cookie settings can be managed from the config/cookie-consent.php file*
```php
'cookie_categories' => [
    'necessary' => [
        'enabled' => true,
        'locked' => true,
    ],
    'analytics' => [
        'enabled' => env('COOKIE_CONSENT_ANALYTICS', true),
        'locked' => false,
        'js_action' => 'loadGoogleAnalytics',
    ],
    'marketing' => [
        'enabled' => env('COOKIE_CONSENT_MARKETING', true),
        'locked' => false,
        'js_action' => 'loadFacebookPixel',
    ],
    'preferences' => [
        'enabled' => env('COOKIE_CONSENT_PREFERENCES', true),
        'locked' => false,
    ],
]
```
*Then you will see an image like the one below on your screen.*<br>
![Demo](https://binovasyon.com/media/cookie-consent-demo.gif)

*The recorded log table is as follows:*<br>
table name : **cookie_consent_logs**

| id    | ip_address | user_agent   | action  | preferences    | url  |
| ----- | ---------- | ------------ | ------- | -------------- | ---- |
bigint  | varchar(255) | text   | varchar(255)  | json  | varchar(255)  |
1  | 255.255.255.*** | Mozil....   | accepted  | {"analytics": true,"marketing": true,"necessary": true,"preferences": true}  | www.project.test    |