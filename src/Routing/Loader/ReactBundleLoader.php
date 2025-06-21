<?php

declare(strict_types=1);

/*
 * This file is part of the ReactBundle package.
 *
 * (c) Andreas Linden <zlx@gmx.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zolex\ReactBundle\Routing\Loader;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class ReactBundleLoader extends Loader
{
    public function supports($resource, $type = null): bool
    {
        return 'react_bundle' === $type;
    }

    public function load(mixed $resource, ?string $type = null): RouteCollection
    {
        $routes = new RouteCollection();
        $routes->add(
            name: 'zolex:react_bundle',
            route: new Route(
                path: '/bundles/{file}',
                defaults: [
                    '_controller' => 'zolex.react_bundle.serve_bundle_assets_action',
                ],
                requirements: ['file' => '.*'],
                methods: ['GET']
            ),
        );

        return $routes;
    }
}
