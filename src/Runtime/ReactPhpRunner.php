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

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use React\EventLoop\Loop;
use React\Http\HttpServer;
use React\Socket\SocketServer;
use Symfony\Component\Runtime\RunnerInterface;
use Zolex\ReactPhpBundle\Kernel\KernelPsr17Adapter;

class ReactPhpRunner implements RunnerInterface
{
    private const DEFAULT_OPTIONS = [
        'host' => '127.0.0.1',
        'port' => 8080,
    ];

    private array $options;

    private KernelPsr17Adapter $kernel;

    public function __construct(private readonly RequestHandlerInterface $requestHandler, array $options = [])
    {
        $options['host'] = $options['host'] ?? $_SERVER['REACT_HOST'] ?? $_ENV['REACT_HOST'] ?? self::DEFAULT_OPTIONS['host'];
        $options['port'] = $options['port'] ?? $_SERVER['REACT_PORT'] ?? $_ENV['REACT_PORT'] ?? self::DEFAULT_OPTIONS['port'];

        $this->options = array_replace_recursive(self::DEFAULT_OPTIONS, $options);
    }

    public function run(): int
    {
        $loop = Loop::get();
        $loop->addSignal(\SIGTERM, function (int $signal) {
            exit(128 + $signal);
        });

        $server = new HttpServer($loop, function (ServerRequestInterface $request) {
            return $this->requestHandler->handle($request);
        });

        $socket = new SocketServer(\sprintf('%s:%s', $this->options['host'], $this->options['port']), [], $loop);
        $server->listen($socket);

        $loop->run();

        return 0;
    }
}
