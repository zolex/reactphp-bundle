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

namespace Zolex\ReactPhpBundle\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ServeBundleAssetsAction
{
    public function __construct(private string $projectDir)
    {
    }

    public function __invoke(string $directory, string $file)
    {
        $baseDir = $this->projectDir.'/public'.('/' !== $directory ? '/'.$directory : '');
        $path = realpath($baseDir.'/'.$file);
        if (false === $path || !is_readable($path) || is_dir($path) || !str_starts_with($path, $baseDir)) {
            throw new NotFoundHttpException();
        }

        $contentType = match (pathinfo($path)['extension']) {
            'css' => 'text/css',
            'html' => 'text/html',
            default => mime_content_type($path),
        };

        return new Response(file_get_contents($path), 200, ['Content-Type' => $contentType]);
    }
}
