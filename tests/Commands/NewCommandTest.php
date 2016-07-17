<?php

use Crafter\Installer\Commands\NewCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class NewCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * Console Application.
     *
     * @var Application
     */
    protected $app;

    /**
     * The NewCommand instance.
     *
     * @var NewCommand
     */
    protected $command;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->app = new Application;
        $this->command = new NewCommand;

        $this->app->add($this->command);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();
        unset($this->app);
        unset($this->command);
    }

    /**
     * Test the validateFramework method
     *
     * @return void
     *
     * @expectedException \RuntimeException
     */
    public function testValidateFrameworkMethodOnNewCommandClass()
    {
        $command = $this->app->find('new');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'framework' => 'FooFramework',
            'name'      => 'BarApplication'
        ]);
    }
}
