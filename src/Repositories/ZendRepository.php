<?php

namespace Crafter\Installer\Repositories;

use Symfony\Component\Yaml\Yaml;

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
        // Get Latest version from file
        $latestVersion = collect(Yaml::parse(file_get_contents(__DIR__ . '/../config/latest-versions.yml')))->get('zend');

        return $this->version == 'latest' ? $latestVersion : $this->version;
    }
}
