<?php

use Crafter\Installer\Commands\Show\ShowFrameworksCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ShowFrameworksCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * Console Application.
     *
     * @var Application
     */
    protected $app;

    /**
     * The ShowCommand instance.
     *
     * @var ShowCommand
     */
    protected $command;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->app = new Application;
        $this->command = new ShowFrameworksCommand;

        $this->app->add($this->command);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown()
    {
        unset($this->app);
        unset($this->command);
    }

    /**
     * Test the show command.
     *
     * @return void
     */
    public function testShowCommandWorksAsExpected()
    {
        $command = $this->app->find('show:frameworks');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $this->assertRegExp('/laravel/', $commandTester->getDisplay());
        $this->assertRegExp('/symfony/', $commandTester->getDisplay());
        $this->assertRegExp('/orchestra/', $commandTester->getDisplay());
        $this->assertRegExp('/zend/', $commandTester->getDisplay());
    }
}
