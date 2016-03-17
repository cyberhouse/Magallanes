<?php
use Mage\Command\Environment\RemoveCommand;
use Pimple\Container;


/**
 * Class RemoveCommandTest
 *
 * @coversDefaultClass Mage\Command\Environment\RemoveCommand
 */
class RemoveCommandTest extends \MageTest\Command\BaseCommandTest
{
    /** @var RemoveCommand */
    private $addCommand;
    /** @var PHPUnit_Framework_MockObject_MockObject */
    private $environmentHelperMock;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelperMock = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(array('environmentExists', 'removeEnvironment'))
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelperMock;
        $this->addCommand = new RemoveCommand($container);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteWithoutNameOption() {
        $arguments = array();
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] The name parameter cannot be empty.";

        $this->executeAndAssert($this->addCommand, 'environment:remove', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteWithNotExistingEnvironment() {
        $environmentName = 'foobar';

        $arguments = array('--name' => $environmentName);
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] The environment \"$environmentName\" does not exist.";

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(false);

        $this->executeAndAssert($this->addCommand, 'environment:remove', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteFailsOnRemoval() {
        $environmentName = 'foobar';

        $arguments = array('--name' => $environmentName);
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] The environment \"$environmentName\" cannot be removed.";

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(true);

        $this->environmentHelperMock
            ->method('removeEnvironment')
            ->willReturn(false);

        $this->executeAndAssert($this->addCommand, 'environment:remove', $arguments, $expectedExitCode, $expectedMessage);
    }

    public function testExecuteSuccess() {
        $environmentName = 'foobar';

        $arguments = array('--name' => $environmentName);
        $expectedExitCode = 0;

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(true);

        $this->environmentHelperMock
            ->method('removeEnvironment')
            ->willReturn(true);

        $this->executeAndAssert($this->addCommand, 'environment:remove', $arguments, $expectedExitCode);
    }
}