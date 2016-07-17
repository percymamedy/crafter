<?php

namespace Crafter\Installer\Commands\Show;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class ShowFrameworksCommand extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('show:frameworks')
             ->setDescription('Lists all available frameworks for install');
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->formatOutput($this->getFrameworkList()));
    }

    /**
     * Format output for console.
     *
     * @param array $list
     *
     * @return array
     */
    public function formatOutput($list)
    {
        return collect($list)->transform(function ($item) {
            return '<info>' . $item . '</info>';
        })->all();
    }

    /**
     * Get a list of available frameworks.
     *
     * @return array
     */
    public function getFrameworkList()
    {
        return collect(Yaml::parse(file_get_contents(__DIR__ . '/../../config/frameworks.yml')))->get('list');
    }
}
