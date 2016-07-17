<?php

namespace Crafter\Installer\Repositories;

class LaravelRepository extends RepositoryFactory
{
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

    /**
     * Will show a message notify start of the process.
     *
     * @return void
     */
    public function showStartMessage()
    {
        $this->getOutput()->writeln('<info>Crafting your Laravel application...</info>');
    }
}
