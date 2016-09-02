<?php

namespace Crafter\Installer\Repositories;

class OrchestraRepository extends RepositoryFactory
{
    /**
     * Installation start message.
     *
     * @var string
     */
    protected $startMessage = 'Crafting your Orchestra platform application...';

    /**
     * Commands that must be run to install Orchestra platform.
     *
     * @return string
     */
    public function getCommandsToRun()
    {
        // Get Composer
        $composer = $this->findComposer();

        // Commands
        $commands = [
            rtrim($composer .
                  ' create-project --prefer-dist --no-scripts orchestra/platform ' .
                  $this->getProjectPath() .
                  ' ' .
                  $this->getVersion(), ' '),
            $composer . ' run-script post-root-package-install',
            $composer . ' run-script post-install-cmd',
            $composer . ' run-script post-create-project-cmd',
        ];

        return implode(' && ', $commands);
    }
}
