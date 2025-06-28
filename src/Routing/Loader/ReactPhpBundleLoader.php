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
    public function supports($resource, $type = null): bool
    {
        return 'reactphp_bundle' === $type;
    }

    public function load(mixed $resource, ?string $type = null): RouteCollection
    {
        $routes = new RouteCollection();
        $routes->add(
            name: 'zolex:reactphp_bundle',
            route: new Route(
                path: '/bundles/{file}',
                defaults: [
                    '_controller' => 'zolex.reactphp_bundle.serve_bundle_assets_action',
                ],
                requirements: ['file' => '.*'],
                methods: ['GET']
            ),
        );

        return $routes;
    }
}
