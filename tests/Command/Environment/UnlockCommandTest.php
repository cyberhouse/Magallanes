<?php
use Mage\Command\Environment\RemoveCommand;
use Mage\Command\Environment\UnlockCommand;
use Pimple\Container;


/**
 * Class UnlockCommandTest
 *
 * @coversDefaultClass Mage\Command\Environment\UnlockCommand
 */
class UnlockCommandTest extends \MageTest\Command\BaseCommandTest
{
    /** @var UnlockCommandTest */
    private $unlockCommand;
    /** @var PHPUnit_Framework_MockObject_MockObject */
    private $environmentHelperMock;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelperMock = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(array('environmentExists', 'unlockEnvironment'))
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelperMock;
        $this->unlockCommand = new UnlockCommand($container);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteWithoutNameOption() {
        $arguments = array();
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] the name parameter cannot be empty.";

        $this->executeAndAssert($this->unlockCommand, 'environment:unlock', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteFailsOnUnlock() {
        $environmentName = 'foobar';

        $arguments = array('--name' => $environmentName);
        $expectedExitCode = 1;
        $expectedMessage = "[ERROR] Unable to release deployment lock for environment $environmentName.";

        $this->environmentHelperMock
            ->method('unlockEnvironment')
            ->willReturn(false);

        $this->executeAndAssert($this->unlockCommand, 'environment:unlock', $arguments, $expectedExitCode, $expectedMessage);
    }

    public function testExecuteSuccess() {
        $environmentName = 'foobar';

        $arguments = array('--name' => $environmentName);
        $expectedExitCode = 0;

        $this->environmentHelperMock
            ->method('unlockEnvironment')
            ->willReturn(true);

        $this->executeAndAssert($this->unlockCommand, 'environment:unlock', $arguments, $expectedExitCode);
    }
}