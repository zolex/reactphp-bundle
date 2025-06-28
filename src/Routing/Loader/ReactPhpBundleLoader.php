<?php

declare(strict_types=1);

/*
 * This file is part of the ReactPhpBundle package.
 *
 * (c) Andreas Linden <zlx@gmx.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zolex\ReactPhpBundle\Routing\Loader;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class ReactPhpBundleLoader extends Loader
{
    private array $assetPaths;
    private string $publicPath;

    public function supports($resource, $type = null): bool
    {
        return 'reactphp_bundle' === $type;
    }

    public function setProjectDir(string $path): void
    {
        $this->publicPath = rtrim($path, '/') . '/public';
    }

    public function setAssetPaths(array $paths): void
    {
        $this->assetPaths = $paths;
    }

    public function load(mixed $resource, ?string $type = null): RouteCollection
    {
        $routes = new RouteCollection();
        foreach ($this->assetPaths as $assetPath) {
            $target = trim($assetPath, '/');
            if (!is_readable($this->publicPath . '/'. $target)) {
                user_error('Tried to register "'. $target . '" asset path, but it does not exist or is not readable.', E_USER_WARNING);
                continue;
            }

            if (is_file($this->publicPath . '/'. $target)) {
                $routes->add(
                    name: 'zolex:reactphp_bundle:' . str_replace('/', '_', $target),
                    route: new Route(
                        path: '/' . $target,
                        defaults: [
                            '_controller' => 'zolex.reactphp_bundle.serve_bundle_assets_action',
                            'directory' => '/',
                            'file' => $target,
                        ],
                        methods: ['GET']
                    ),
                );
            } else {
                $routes->add(
                    name: 'zolex:reactphp_bundle:' . str_replace('/', '_', $target),
                    route: new Route(
                        path: '/' . $target . '/{file}',
                        defaults: [
                            '_controller' => 'zolex.reactphp_bundle.serve_bundle_assets_action',
                            'directory' => $target,
                        ],
                        requirements: ['file' => '.*'],
                        methods: ['GET']
                    ),
                );
            }
        }

        return $routes;
    }
}
