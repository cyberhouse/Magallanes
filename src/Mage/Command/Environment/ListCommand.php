<?php
namespace Mage\Command\Environment;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 */
class ListCommand extends EnvironmentCommand
{
    protected function configure()
    {
        $this->setName("environment:list")
            ->setDescription("Lists available deployment environments")
            ->setDefinition(array())
            ->setHelp(<<<EOT
Lists available deployment environments

Usage:
<info>bin/mage environment:list</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = $this->getIO();

        $environments = $this->environmentHelper->getAvailableEnvironments();

        if(empty($environments)) {

            $io->warning("There are no environment configurations available");
        }
        else {
            $io->title("Available environments");
            $io->listing($environments);
        }

        return $this->success();
    }

}