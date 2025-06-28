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

namespace Zolex\ReactPhpBundle\Runtime;

use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Runtime\RunnerInterface;

class ReactPhpRunner implements RunnerInterface
{
    private RequestHandlerInterface $application;
    private ServerFactory $serverFactory;

    public function __construct(ServerFactory $serverFactory, RequestHandlerInterface $application)
    {
        $this->serverFactory = $serverFactory;
        $this->application = $application;
    }

    public function run(): int
    {
        $loop = $this->serverFactory->createServer($this->application);
        $loop->run();

        return 0;
    }
}
