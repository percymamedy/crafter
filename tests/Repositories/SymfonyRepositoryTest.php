<?php

use Crafter\Installer\Repositories\SymfonyRepository;
use Mockery as m;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * The Repository.
     *
     * @var SymfonyRepository
     */
    protected $repo;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->repo = m::mock(SymfonyRepository::class . '[runCommands,hasSymfonyInstaller,symfonyInstallerPath,findSymfony]', [
            m::mock(InputInterface::class),
            m::mock(OutputInterface::class),
            'FooProject',
            'latest',
        ]);
        $this->repo->shouldReceive('hasSymfonyInstaller')->andReturn(true);
        $this->repo->shouldReceive('symfonyInstallerPath')->andReturn('symfony.phar');
        $this->repo->shouldReceive('findSymfony')->andReturn(PHP_BINARY . ' symfony.phar');
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown()
    {
        m::close();
        unset($this->repo);
    }

    /**
     * Test get the commands to run.
     *
     * @return void
     */
    public function testGetCommandsToRunMethod()
    {
        $this->assertEquals(
            PHP_BINARY . ' symfony.phar new ' . getcwd() . DIRECTORY_SEPARATOR . 'FooProject',
            $this->repo->getCommandsToRun()
        );
    }
}
