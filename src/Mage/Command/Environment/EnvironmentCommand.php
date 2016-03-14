<?php


namespace Mage\Command\Environment;
use Mage\Command\BaseCommand;
use Mage\Helper\Environment\EnvironmentHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class EnvironmentCommand
 */
abstract class EnvironmentCommand extends BaseCommand
{
    /**
 * @var EnvironmentHelper 
*/
    protected $environmentHelper;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->environmentHelper = $this->getContainer()['environmentHelper'];
    }
}