<?php

namespace Crafter\Installer\Repositories;

use GuzzleHttp\Client;

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
        // Get symfony
        $symfony = $this->findSymfony();

        // Commands
        $commands = [
            rtrim($symfony . ' new ' . $this->getProjectPath() . ' ' . $this->getVersion()),
        ];

        return implode(' && ', $commands);
    }

    /**
     * Find the symfony installer.
     *
     * @return string
     */
    public function findSymfony()
    {
        // We have symfony installer
        if (! $this->hasSymfonyInstaller()) {
            $this->downloadSymfonyInstaller();
        }

        // Return Installer path
        return PHP_BINARY . ' ' . realpath($this->symfonyInstallerPath());
    }

    /**
     * Checks if symfony installer exists.
     *
     * @return bool
     */
    public function hasSymfonyInstaller()
    {
        return file_exists($this->symfonyInstallerPath());
    }

    /**
     * Return the symfony.phar path.
     *
     * @return string
     */
    public function symfonyInstallerPath()
    {
        return __DIR__ . '/../../symfony.phar';
    }

    /**
     * Download symfony installer.
     *
     * @return void
     */
    public function downloadSymfonyInstaller()
    {
        $response = $this->getClient()->get('https://symfony.com/installer');
        file_put_contents($this->symfonyInstallerPath(), $response->getBody());
    }

    /**
     * The GuzzleClient.
     *
     * @return Client
     */
    public function getClient()
    {
        return new Client;
    }
}
