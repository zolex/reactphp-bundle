# ReactPHP Symfony Bundle

[![Release](https://github.com/zolex/ReactBundle/workflows/Release/badge.svg)](https://github.com/zolex/ReactBundle/actions)
![Version](https://img.shields.io/packagist/v/zolex/ReactBundle)
[![Integration](https://github.com/zolex/ReactBundle/workflows/Integration/badge.svg)](https://github.com/zolex/ReactBundle/actions)
[![Code Coverage](https://codecov.io/gh/zolex/ReactBundle/graph/badge.svg?token=Swt3B6XMUw)](https://codecov.io/gh/zolex/ReactBundle)


![License](https://img.shields.io/packagist/l/zolex/ReactBundle)
![Downloads](https://img.shields.io/packagist/dt/zolex/ReactBundle)

![ReactBundle](docs/logo.jpg)

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white)

A Symfony Bundle providing a Runtime for ReactPHP, a PSR-17 Kernel and a Router to serve assets.

### Installation

```bash
composer require zolex/react-bundle
```

### Configuration

To run your symfony application using the ReactPHP server. You need to modify the default `public/index.php` (or create a new file like `app.php`) with the following content.

```php
<?php

use App\Kernel;
use Zolex\ReactBundle\Kernel\KernelPsr17Adapter;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new KernelPsr17Adapter(new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']));
};
```

### Assets

To allow serving public bundle assets (like API-Platform's Swagger-UI) through ReactPHP, add this file to your project `config/routes/react_bundle.yaml`
```yaml
react_bundle:
  type: react_bundle
  resource: .
```

### Start the server

```bash
APP_RUNTIME="Zolex\\ReactBundle\\Runtime\\ReactRuntime" php public/index.php
```

### Credits

This bundle is inspired by [runtime/reactphp](https://github.com/php-runtime/reactphp).