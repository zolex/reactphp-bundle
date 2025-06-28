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
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Runtime\GenericRuntime;
use Symfony\Component\Runtime\Internal\MissingDotenv;
use Symfony\Component\Runtime\Internal\SymfonyErrorHandler;
use Symfony\Component\Runtime\RunnerInterface;

class ReactPhpRuntime extends GenericRuntime
{
    public function __construct(array $options = [])
    {
        $envKey = $options['env_var_name'] ??= 'APP_ENV';
        $debugKey = $options['debug_var_name'] ??= 'APP_DEBUG';

        if (!($options['disable_dotenv'] ?? false) && isset($options['project_dir']) && !class_exists(MissingDotenv::class, false)) {
            $overrideExistingVars = $options['dotenv_overload'] ?? false;
            $dotenv = (new Dotenv($envKey, $debugKey))
                ->setProdEnvs((array) ($options['prod_envs'] ?? ['prod']))
                ->usePutenv($options['use_putenv'] ?? false);

            $dotenv->bootEnv($options['project_dir'].'/'.($options['dotenv_path'] ?? '.env'), 'dev', (array) ($options['test_envs'] ?? ['test']), $overrideExistingVars);

            if (\is_array($options['dotenv_extra_paths'] ?? null) && $options['dotenv_extra_paths']) {
                $options['dotenv_extra_paths'] = array_map(fn (string $path) => $options['project_dir'].'/'.$path, $options['dotenv_extra_paths']);

                $overrideExistingVars
                    ? $dotenv->overload(...$options['dotenv_extra_paths'])
                    : $dotenv->load(...$options['dotenv_extra_paths']);
            }

            if (isset($this->input) && $overrideExistingVars) {
                if ($this->input->getParameterOption(['--env', '-e'], $_SERVER[$envKey], true) !== $_SERVER[$envKey]) {
                    throw new \LogicException(\sprintf('Cannot use "--env" or "-e" when the "%s" file defines "%s" and the "dotenv_overload" runtime option is true.', $options['dotenv_path'] ?? '.env', $envKey));
                }

                if ($_SERVER[$debugKey] && $this->input->hasParameterOption('--no-debug', true)) {
                    putenv($debugKey.'='.$_SERVER[$debugKey] = $_ENV[$debugKey] = '0');
                }
            }

            $options['debug'] ??= '1' === $_SERVER[$debugKey];
            $options['disable_dotenv'] = true;
        } else {
            $_SERVER[$envKey] ??= $_ENV[$envKey] ?? 'dev';
            $_SERVER[$debugKey] ??= $_ENV[$debugKey] ?? !\in_array($_SERVER[$envKey], (array) ($options['prod_envs'] ?? ['prod']), true);
        }

        $options['error_handler'] ??= SymfonyErrorHandler::class;

        parent::__construct($options);
    }

    public function getRunner(?object $application): RunnerInterface
    {
        if ($application instanceof RequestHandlerInterface) {
            return new ReactPhpRunner(new ServerFactory($this->options), $application);
        }

        return parent::getRunner($application);
    }
}
