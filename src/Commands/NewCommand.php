<?php

namespace Crafter\Installer\Commands;

use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Yaml\Yaml;

class NewCommand extends Command
{
    /**
     * The framework to install.
     *
     * @var string
     */
    protected $framework;

    /**
     * An input interface.
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * The name of the project.
     *
     * @var string
     */
    protected $name;

    /**
     * An output interface.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * The version of the framework to install.
     *
     * @var string
     */
    protected $version;

    /**
     * Outputs the successful install message.
     *
     * @return void
     */
    public function alertSuccessInstall()
    {
        $this->getOutputInterface()
             ->writeln('<comment>Your "'.$this->getFramework().'" application is installed and ready to go !!</comment>');
    }

    /**
     * Ask the User to input the framework to install.
     *
     * @return void
     */
    protected function askForFramework()
    {
        $helper = $this->getHelper('question');
        $question = new Question('Which framework do you want to install [Defaults to laravel] ? ', 'laravel');
        $question->setValidator(function ($answer) {
            return $this->validateFramework($answer);
        });
        $question->setMaxAttempts(2);

        // Get the framework.
        $this->framework = $helper->ask($this->getInputInterface(), $this->getOutputInterface(), $question);
    }

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('new')
             ->setDescription('Crafts a new PHP framework')
             ->addArgument('framework', InputArgument::REQUIRED, 'The name of the framework to install')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the application')
             ->addArgument('version', InputArgument::OPTIONAL, 'The version of the framework to use', 'latest');
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
        // Get Repository class that performs the installation.
        $repo = $this->getRepo();

        // Install framework
        $repo = new $repo(
            $input,
            $output,
            $this->getProjectName(),
            $this->getVersion()
        );
        $repo->install();

        // Install over print message
        $this->alertSuccessInstall();
    }

    /**
     * Get the framework to install.
     *
     * @return string
     */
    public function getFramework()
    {
        return $this->framework;
    }

    /**
     * Return the available frameworks.
     *
     * @return array
     */
    public function getFrameworksRepo()
    {
        return collect(Yaml::parse(file_get_contents(__DIR__.'/../config/frameworks.yml')))->get('list');
    }

    /**
     * Get the input interface implementation.
     *
     * @return InputInterface
     */
    public function getInputInterface()
    {
        return $this->input;
    }

    /**
     * Get the output interface implementation.
     *
     * @return OutputInterface
     */
    public function getOutputInterface()
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
        return $this->name;
    }

    /**
     * Get the Repository class that performs the installation
     * for the given framework.
     *
     * @return string
     */
    public function getRepo()
    {
        // Get Available repos
        $repos = collect(Yaml::parse(file_get_contents(__DIR__.'/../config/frameworks.yml')))->get('repos');

        return collect($repos)->get($this->getFramework());
    }

    /**
     * Get the version of the framework to use.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Determine if user has input framework.
     *
     * @return bool
     */
    public function hasFramework()
    {
        return !is_null($this->getFramework());
    }

    /**
     * Initializes the command just after the input has been validated.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->framework = !is_null($input->getArgument('framework')) ? $this->validateFramework($input->getArgument('framework')) : null;
        $this->name = $input->getArgument('name');
        $this->version = $input->getArgument('version');
    }

    /**
     * Interacts with the user.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        // Determine whether the user has specified a
        // framework to install with, if not as him.
        if (!$this->hasFramework()) {
            $this->askForFramework();
        }
    }

    /**
     * Validate the name of the framework to be installed.
     *
     * @param string $framework
     *
     * @return string
     */
    public function validateFramework($framework)
    {
        // Get available frameworks.
        $available = collect($this->getFrameworksRepo());

        // Determine whether this framework is valid.
        if (!$available->contains($framework)) {
            throw new RuntimeException('Framework "'.$framework.'" is not available for installation !');
        }

        // Return it.
        return $framework;
    }
}
