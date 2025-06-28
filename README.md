# ReactPHP Symfony Bundle

[![Release](https://github.com/zolex/ReactPhpBundle/workflows/Release/badge.svg)](https://github.com/zolex/ReactPhpBundle/actions)
![Version](https://img.shields.io/packagist/v/zolex/ReactPhpBundle)
[![Integration](https://github.com/zolex/ReactPhpBundle/workflows/Integration/badge.svg)](https://github.com/zolex/ReactPhpBundle/actions)
[![Code Coverage](https://codecov.io/gh/zolex/ReactPhpBundle/graph/badge.svg?token=Swt3B6XMUw)](https://codecov.io/gh/zolex/ReactPhpBundle)


![License](https://img.shields.io/packagist/l/zolex/ReactPhpBundle)
![Downloads](https://img.shields.io/packagist/dt/zolex/ReactPhpBundle)

![ReactPhpBundle](docs/logo.jpg)

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white)

A Symfony Bundle providing a Runtime for ReactPHP, a PSR-17 Kernel and a Router to serve assets.

### Installation

```bash
composer require zolex/react-bundleF
```

### Configuration

To run your symfony application using the ReactPHP server. You need to modify the default `public/index.php` (or create a new file like `app.php`) with the following content.

```php
<?php

use App\Kernel;
use Zolex\ReactPhpBundle\Kernel\KernelPsr17Adapter;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new KernelPsr17Adapter(new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']));
};
```

### Assets

To allow serving assets from the public directory through ReactPHP, add this file to your project `config/routes/react_bundle.yaml`
```yaml
reactphp_bundle:
  type: reactphp_bundle
  resource: .
```

By default, only files in the `public/bundles` directory are served (like Swagger-UI in API-Platform).
Additional directories and files can be registered in the bundle config at `config/bundles/zolex_react_php.yaml`:

```yaml
zolex_react_php:
    asset_paths:
        - /bundles/
        - /custom-dir/
        - /single-file.js
        - /another/single/file.css
```

### Start the server

```bash
APP_RUNTIME="Zolex\\ReactPhpBundle\\Runtime\\ReactPhpRuntime" php public/index.php
```
