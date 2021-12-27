# Laravel nova ad manager

![Packagist License](https://img.shields.io/packagist/l/yaroslawww/nova-ad-director?color=%234dc71f)
[![Packagist Version](https://img.shields.io/packagist/v/yaroslawww/nova-ad-director)](https://packagist.org/packages/yaroslawww/nova-ad-director)
[![Total Downloads](https://img.shields.io/packagist/dt/yaroslawww/nova-ad-director)](https://packagist.org/packages/yaroslawww/nova-ad-director)
[![Build Status](https://scrutinizer-ci.com/g/yaroslawww/nova-ad-director/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/nova-ad-director/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/yaroslawww/nova-ad-director/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/nova-ad-director/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yaroslawww/nova-ad-director/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/nova-ad-director/?branch=master)

Laravel nova ad manager to display advertise on site.

## Installation

You can install the package via composer:

```bash
composer require yaroslawww/nova-ad-director

# optional publish configs
php artisan vendor:publish --provider="NovaAdDirector\ServiceProvider" --tag="config"

# publish translations
php artisan vendor:publish --provider="NovaAdDirector\ServiceProvider" --tag="lang"
```

## Usage

1. Package supports only predefined sizes. That why developer should firstly
   specify ["global" sizes](https://github.com/yaroslawww/laravel-ad-director#usage)
2. Inherit or add to nova AdConfiguration Resource
3. Inherit or add to auth service provider AdConfigurationPolicy
4. If app uses configuration with "creatable==false" then developer need create new locations
   manually `php artisan nova-ad-director:ad-config:create <key-name> <locaion-name>`
5. Then configure ads in your system

```php
use NovaAdDirector\Facades\NovaAdDirector;

class FrontpageController extends Controller
{
    public function __invoke()
    {
        NovaAdDirector::prepareAds([
            'header' => NovaAdDirector::fallbackKey('header', 'frontpage'),
            'medium-posts-list' => NovaAdDirector::fallbackKey('medium', 'list', 'frontpage'),
            'footer-v2' => NovaAdDirector::fallbackKey('footer', 'frontpage'),
        ]);

        return view('frontpage');
    }
}
```

### Key fallback search flow

In multiple situation good to have possibility to use same ad for multiple pages but with some specific ad on specific
page, etc. Solution is using fallback flow:

Each key can be computed form multiple nested pointers and system will try to find parent key in case of child is empty.

For example site has multiple pages and multiple posts. That why different pages and posts will search keys like these:

- `header:page:frontpage`
- `header:page:contact-us`
- `header:post:12`
- `header:post:654`

each this keys will search fallbacks:

- `header:page:frontpage` => `header:page` => `header`
- `header:page:contact-us` => `header:page` => `header`
- `header:post:12` => `header:post` => `header`
- `header:post:654` => `header:post` => `header`

Administrator in admin can specify only `header` configuration and in any moment add some specific AD item like
`header:page:contact-us` to override ad only for contact us page or `header:post` to use specific ad only on posts.

#### Override default fallback separator

```php
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
       \NovaAdDirector\NovaAdDirector::setFallbackKeyConnector('/');
    }
}
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/)
