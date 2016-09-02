<?php

use Crafter\Installer\Repositories\OrchestraRepository;
use Mockery as m;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrchestraRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * The Repository.
     *
     * @var OrchestraRepository
     */
    protected $repo;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->repo = m::mock(OrchestraRepository::class . '[runCommands]', [
            m::mock(InputInterface::class),
            m::mock(OutputInterface::class),
            'FooProject',
            'latest',
        ]);
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
            [
                'composer create-project --prefer-dist --no-scripts orchestra/platform ' . getcwd() . DIRECTORY_SEPARATOR . 'FooProject',
                'composer run-script post-root-package-install',
                'composer run-script post-install-cmd',
                'composer run-script post-create-project-cmd',
            ],
            explode(' && ', $this->repo->getCommandsToRun())
        );
    }
}
