<?php
use Mage\Command\Environment\AddCommand;
use Pimple\Container;


/**
 * Class AddCommandTest
 */
class AddCommandTest extends \MageTest\Command\BaseCommandTest
{
    private $addCommand;
    private $environmentHelper;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelper = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(array('environmentExists', 'addEnvironment'))
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelper;
        $this->addCommand = new AddCommand($container);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithoutNameOption() {
        $arguments = array();
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] the name parameter cannot be empty.";

        $this->executeTest($this->addCommand, 'environment:add', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithExistingEnvironment() {
        $environmentName = 'foo';

        $arguments = array('--name' => $environmentName);
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] the environment \"$environmentName\" already exists.";

        $this->environmentHelper->method('environmentExists')->willReturn(true);

        $this->executeTest($this->addCommand, 'environment:add', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithoutEnabledReleases() {
        $arguments = array(
            '--name' => 'foo',
            '--enableReleases' => false
        );

        $expectedExitCode = 0;

        $this->environmentHelper
            ->method('environmentExists')
            ->willReturn(false);

        $this->environmentHelper
            ->expects($this->any(), false)
            ->method('addEnvironment')
            ->willReturn(true);

        $this->executeTest($this->addCommand, 'environment:add', $arguments, $expectedExitCode);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithAddError() {
        $arguments = array(
            '--name' => 'foo',
            '--enableReleases' => false
        );

        $expectedExitCode = 1;

        $this->environmentHelper
            ->method('environmentExists')
            ->willReturn(false);

        $this->environmentHelper
            ->expects($this->any(), false)
            ->method('addEnvironment')
            ->willReturn(false);

        $this->executeTest($this->addCommand, 'environment:add', $arguments, $expectedExitCode);
    }
}