# ReactPHP Symfony Bundle

[![Release](https://github.com/zolex/reactphp-bundle/workflows/Release/badge.svg)](https://github.com/zolex/ReactPhpBundle/actions)
![Version](https://img.shields.io/packagist/v/zolex/reactphp-bundle)
[![Integration](https://github.com/zolex/reactphp-bundle/workflows/Integration/badge.svg)](https://github.com/zolex/reactphp-bundle/actions)
[![Code Coverage](https://codecov.io/gh/zolex/reactphp-bundle/graph/badge.svg?token=Swt3B6XMUw)](https://codecov.io/gh/zolex/reactphp-bundle)


![License](https://img.shields.io/packagist/l/zolex/reactphp-bundle)
![Downloads](https://img.shields.io/packagist/dt/zolex/reactphp-bundle)

![ReactPhpBundle](docs/logo.jpg)

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white)

A Symfony Bundle providing a Runtime for [ReactPHP](https://github.com/reactphp/reactphp), a PSR-17 Kernel and a Router to serve assets.

Turn any Symfony project into a "self-serving" application, no traditional webserver required.

### Installation

```bash
composer require zolex/reactphp-bundle
```

### Start the server

```bash
APP_RUNTIME="Zolex\\ReactPhpBundle\\Runtime\\ReactPhpRuntime" php public/index.php
```

For a very basic docker example, check the [Dockerfile](./docs/Dockerfile) in the docs folder.

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
