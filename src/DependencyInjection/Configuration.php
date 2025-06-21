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

namespace Zolex\ReactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('zolex_react');
        //        $rootNode = $treeBuilder->getRootNode();
        //
        //        $rootNode
        //            ->children()
        //                ->arrayNode('services')
        //                    ->useAttributeAsKey('class')
        //                    ->arrayPrototype()
        //                    ->performNoDeepMerging()
        //                    ->children()
        //                        ->scalarNode('prefix')->defaultValue('/twirp')->end()
        //                    ->end()
        //                ->end()
        //            ->end();

        return $treeBuilder;
    }
}
