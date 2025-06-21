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

namespace Zolex\ReactBundle\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ServeBundleAssetsAction
{
    public function __construct(private string $projectDir)
    {
    }

    public function __invoke(string $file)
    {
        $path = $this->projectDir.'/public/bundles/'.$file;

        if (!is_readable($path)) {
            throw new NotFoundHttpException("'$file' is not readable.");
        }

        if (is_dir($path)) {
            throw new NotFoundHttpException("'$file' is a directory.");
        }

        $contentType = match (pathinfo($path)['extension']) {
            'css' => 'text/css',
            'html' => 'text/html',
            default => mime_content_type($path),
        };

        return new Response(file_get_contents($path), 200, ['Content-Type' => $contentType]);
    }
}
