<?php
use Mage\Command\Environment\AddCommand;
use Pimple\Container;


/**
 * Class ListCommandTest
 */
class ListCommandTest extends \MageTest\Command\BaseCommandTest
{
    private $listCommand;
    private $environmentHelper;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelper = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(array('getAvailableEnvironments'))
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelper;
        $this->listCommand = new \Mage\Command\Environment\ListCommand($container);
    }

    /**
     * @covers Mage\Command\Environment\ListCommand::execute
     */
    public function testExecuteWithNoEnvironmentsShowsWarning() {
        $arguments = array();
        $expectedExitCode = 0;
        $expectedMessage = "[WARNING] There are no environment configurations available";

        $this->environmentHelper->method('getAvailableEnvironments')->willReturn(array());

        $this->executeTest($this->listCommand, 'environment:list', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers Mage\Command\Environment\ListCommand::execute
     */
    public function testExecuteWithExistingEnvironments() {
        $arguments = array();
        $expectedExitCode = 0;

        $this->environmentHelper->method('getAvailableEnvironments')->willReturn(array('foo', 'bar'));

        $this->executeTest($this->listCommand, 'environment:list', $arguments, $expectedExitCode);
    }
}