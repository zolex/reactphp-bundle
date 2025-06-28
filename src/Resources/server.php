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

use App\Kernel;
use Zolex\ReactPhpBundle\Kernel\KernelPsr17Adapter;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new KernelPsr17Adapter(new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']));
};
