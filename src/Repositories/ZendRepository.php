<?php

namespace Crafter\Installer\Repositories;

class ZendRepository extends RepositoryFactory
{
    /**
     * Installation start message.
     *
     * @var string
     */
    protected $startMessage = 'Crafting your Zend Framework application...';

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
            rtrim($composer . ' create-project -n -sdev zendframework/skeleton-application ' . $this->getProjectPath() . ' ' . $this->getVersion(), ' '),
        ];

        return implode(' && ', $commands);
    }

    /**
     * Get the version of the framework to use.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version == 'latest' ? '3.0.*' : $this->version;
    }
}
