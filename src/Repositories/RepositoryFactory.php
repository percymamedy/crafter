<?php

namespace Crafter\Installer\Repositories;

use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

abstract class RepositoryFactory
{
    /**
     * An InputInterface instance.
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * An OutputInterface instance.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * The name of the project.
     *
     * @var string
     */
    protected $projectName;

    /**
     * Installation start message.
     *
     * @var string
     */
    protected $startMessage = 'Crafting your application...';

    /**
     * The version of the framework to install.
     *
     * @var string
     */
    protected $version;

    /**
     * Create new instance of RepositoryFactory.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param string          $projectName
     * @param string          $version
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        $projectName,
        $version
    ) {
        $this->input = $input;
        $this->output = $output;
        $this->projectName = $projectName;
        $this->version = $version;
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    public function findComposer()
    {
        if (file_exists($this->getCurrentWorkingDirectory() . '/composer.phar')) {
            return '"' . PHP_BINARY . '" composer.phar';
        }

        return 'composer';
    }

    /**
     * Get the current working directory path.
     *
     * @return string
     */
    public function getCurrentWorkingDirectory()
    {
        return getcwd();
    }

    /**
     * Get the InputInterface instance.
     *
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Get the OutputInterface instance.
     *
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Return the name of the project.
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * The full path of the project.
     *
     * @return string
     */
    public function getProjectPath()
    {
        return $this->getCurrentWorkingDirectory() . DIRECTORY_SEPARATOR . $this->getProjectName();
    }

    /**
     * Get the version of the framework to use.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version == 'latest' ? '' : $this->version;
    }

    /**
     * Installs the framework.
     *
     * @return void
     */
    public function install()
    {
        // Verify that Application does not exists.
        $this->verifyApplicationDoesntExist();

        // Show start message.
        $this->showStartMessage();

        // Get all commands that we should run
        $commands = $this->getCommandsToRun();

        // Actually runs the commands
        $this->runCommands($commands);
    }

    /**
     * Run download ans install commands.
     *
     * @param string $commands
     *
     * @return void
     */
    public function runCommands($commands)
    {
        // Create process
        $process = new Process($commands, $this->getCurrentWorkingDirectory(), null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }

        // Run the Process
        $process->run(function ($type, $line) {
            $this->output->write($line);
        });
    }

    /**
     * Will show a message notify start of the process.
     *
     * @return void
     */
    public function showStartMessage()
    {
        $this->getOutput()->writeln('<info>' . $this->startMessage . '</info>');
    }

    /**
     * Verify that the application does not already exist.
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function verifyApplicationDoesntExist()
    {
        if ((is_dir($this->getProjectPath()) || is_file($this->getProjectPath())) && $this->getProjectPath() != $this->getCurrentWorkingDirectory()) {
            throw new RuntimeException('Application already exists!');
        }
    }
}
