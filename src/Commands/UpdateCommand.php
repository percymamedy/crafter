<?php

namespace Crafter\Installer\Commands;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class UpdateCommand extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('update')
             ->setDescription('Updates some of the tools');
    }

    /**
     * Download symfony installer.
     *
     * @return void
     */
    public function downloadSymfonyInstaller()
    {
        $response = $this->getClient()->request('GET', 'https://symfony.com/installer');
        file_put_contents(__DIR__ . '/../../symfony.phar', $response->getBody());
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Start message
        $output->writeln('<info>Updating tools, this may take sometime...</info>');

        // Check if we have symfony installer
        if (! $this->hasSymfonyInstaller()) {
            $this->downloadSymfonyInstaller();
        } else {
            // Create process
            $process = new Process(PHP_BINARY . ' symfony.phar self-update', getcwd(), null, null, null);
            // Run the Process
            $process->run();
        }

        // Output update completed
        $output->writeln('<comment>Tools update completed !</comment>');
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

    /**
     * Checks if symfony installer exists.
     *
     * @return bool
     */
    public function hasSymfonyInstaller()
    {
        return file_exists(__DIR__ . '/../../symfony.phar');
    }
}
