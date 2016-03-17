<?php
use Mage\Command\Environment\AddCommand;
use Pimple\Container;


/**
 * Class ListCommandTest
 */
class ListCommandTest extends \MageTest\Command\BaseCommandTest
{
    /** @var \Mage\Command\Environment\ListCommand */
    private $listCommand;
    /** @var PHPUnit_Framework_MockObject_MockObject */
    private $environmentHelperMock;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelperMock = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(array('getAvailableEnvironments'))
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelperMock;
        $this->listCommand = new \Mage\Command\Environment\ListCommand($container);
    }

    /**
     * @covers Mage\Command\Environment\ListCommand::execute
     */
    public function testExecuteWithNoEnvironmentsShowsWarning() {
        $arguments = array();
        $expectedExitCode = 0;
        $expectedMessage = "[WARNING] There are no environment configurations available";

        $this->environmentHelperMock->method('getAvailableEnvironments')->willReturn(array());

        $this->executeAndAssert($this->listCommand, 'environment:list', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers Mage\Command\Environment\ListCommand::execute
     */
    public function testExecuteWithExistingEnvironments() {
        $arguments = array();
        $expectedExitCode = 0;

        $this->environmentHelperMock->method('getAvailableEnvironments')->willReturn(array('foo', 'bar'));

        $this->executeAndAssert($this->listCommand, 'environment:list', $arguments, $expectedExitCode);
    }
}