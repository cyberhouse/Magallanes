<?php
use Mage\Command\Environment\AddCommand;
use Pimple\Container;


/**
 * Class AddCommandTest
 */
class AddCommandTest extends \MageTest\Command\BaseCommandTest
{
    /** @var AddCommand */
    private $addCommand;
    /** @var PHPUnit_Framework_MockObject_MockObject */
    private $environmentHelperMock;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelperMock = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(array('environmentExists', 'addEnvironment'))
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelperMock;
        $this->addCommand = new AddCommand($container);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithoutNameOption() {
        $arguments = array();
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] the name parameter cannot be empty.";

        $this->executeAndAssert($this->addCommand, 'environment:add', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithExistingEnvironment() {
        $environmentName = 'foo';

        $arguments = array('--name' => $environmentName);
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] the environment \"$environmentName\" already exists.";

        $this->environmentHelperMock->method('environmentExists')->willReturn(true);

        $this->executeAndAssert($this->addCommand, 'environment:add', $arguments, $expectedExitCode, $expectedMessage);
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

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(false);

        $this->environmentHelperMock
            ->expects($this->any(), false)
            ->method('addEnvironment')
            ->willReturn(true);

        $this->executeAndAssert($this->addCommand, 'environment:add', $arguments, $expectedExitCode);
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

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(false);

        $this->environmentHelperMock
            ->expects($this->any(), false)
            ->method('addEnvironment')
            ->willReturn(false);

        $this->executeAndAssert($this->addCommand, 'environment:add', $arguments, $expectedExitCode);
    }
}