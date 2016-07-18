<?php

namespace Crafter\Installer\Repositories;

class SymfonyRepository extends RepositoryFactory
{
    /**
     * Installation start message.
     *
     * @var string
     */
    protected $startMessage = 'Crafting your Symfony application...';

    /**
     * Commands that must be run to install Symfony.
     *
     * @return string
     */
    public function getCommandsToRun()
    {
        // Get Composer
        $composer = $this->findComposer();

        // Commands
        $commands = [
            rtrim($composer . ' create-project symfony/framework-standard-edition ' . $this->getProjectPath() . ' ' . $this->getVersion(), ' '),
        ];

        return implode(' && ', $commands);
    }
}
