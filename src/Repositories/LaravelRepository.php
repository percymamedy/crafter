<?php

namespace Crafter\Installer\Repositories;

class LaravelRepository extends RepositoryFactory
{
    /**
     * Installation start message.
     *
     * @var string
     */
    protected $startMessage = 'Crafting your Laravel application...';

    /**
     * Commands that must be run to install Laravel.
     *
     * @return string
     */
    public function getCommandsToRun()
    {
        // Get Composer
        $composer = $this->findComposer();

        // Commands
        $commands = [
            rtrim($composer . ' create-project --prefer-dist laravel/laravel ' . $this->getProjectPath() . ' ' . $this->getVersion(), ' '),
        ];

        return implode(' && ', $commands);
    }
}
