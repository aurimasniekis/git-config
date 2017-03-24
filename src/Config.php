<?php

namespace AurimasNiekis\GitConfig;

use InvalidArgumentException;
use AurimasNiekis\GitConfig\Exception\GitNotFoundException;

/**
 * Class Config
 *
 * @package AurimasNiekis\GitConfig
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class Config
{
    /**
     * @var string
     */
    private $gitExecutable;

    /**
     * @var string
     */
    private $gitConfigFile;

    public function __construct(string $gitExecutable = null, string $gitConfigFile = null)
    {
        if (null === $gitExecutable) {
            $exitCode = rtrim(shell_exec('which git > /dev/null; echo $?'));

            if ('0' !== $exitCode) {
                throw new GitNotFoundException();
            }
        } else {
            $this->gitExecutable = $gitExecutable;
        }

        $this->gitConfigFile = $gitConfigFile;
    }

    public function get(string $name, bool $global = false, bool $system = false, bool $allScopes = true)
    {
        $command = $this->getScopeFlags($global, $system, $allScopes);

        $command .= ' --get ' . $name;

        return $this->executeCommand($command);
    }

    public function set(string $name, string $value, bool $global = false, bool $system = false)
    {
        $command = $this->getScopeFlags($global, $system);

        $command .= ' ' . $name . ' "' . $value . '"';

        return $this->executeCommand($command);
    }

    public function unSet(string $name, bool $global = false, bool $system = false)
    {
        $command = $this->getScopeFlags($global, $system);

        $command .= ' --unset ' . $name;

        return $this->executeCommand($command);
    }

    private function getScopeFlags(bool $global = false, bool $system = false, bool $allScopes = null)
    {
        $command = '';

        $flags = 0;
        if (true === $global) {
            $flags++;

            $command .= ' --global';
        }

        if (true === $system) {
            $flags++;

            $command .= ' --system';
        }

        if (true === $allScopes) {
            $flags++;
        }

        if (1 < $flags || (null !== $allScopes && 0 === $flags)) {
            throw new InvalidArgumentException(
                'Only $global, $system or $allScopes could be "true" at same time'
            );
        }

        return $command;
    }

    private function getGitExecutable(): string
    {
        return $this->gitExecutable ?? 'git';
    }

    private function getGitConfigFile(): string
    {
        if (null !== $this->gitConfigFile) {
            return ' --file ' . $this->gitConfigFile;
        }

        return '';
    }

    private function executeCommand(string $command): string
    {
        return rtrim(
            shell_exec(
                sprintf(
                    '%s config%s%s',
                    $this->getGitExecutable(),
                    $this->getGitConfigFile(),
                    $command
                )
            )
        );
    }
}