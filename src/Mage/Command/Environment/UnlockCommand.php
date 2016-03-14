<?php
namespace Mage\Command\Environment;

use Mage\Command\BaseCommand;
use Mage\Configuration\Environment;
use Mage\Configuration\General;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UnlockCommand
 */
class UnlockCommand extends EnvironmentCommand
{
    protected function configure()
    {
        $this->setName("environment:unlock")
            ->setDescription("Unlocks the deployment to the given environment")
            ->setDefinition(
                array(
                new InputOption('name', 'e', InputOption::VALUE_REQUIRED, 'the name of the deployment environment', null)
                )
            )
            ->setHelp(
                <<<EOT
Unlocks the deployment to the given environment

Usage:
<info>bin/mage environment:unlock --name="environment"</info>
or
<info>bin/mage environment:unlock -e environment</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environmentName = $input->getOption('name');

        if(empty($environmentName)) {
            return $this->error("the name parameter cannot be empty.");
        }

        if($this->environmentHelper->unlockEnvironment($environmentName)) {
            return $this->success("Released deployment lock for environment $environmentName.");
        }
        else {
            return $this->error("Unable to release deployment lock for environment $environmentName.");
        }
    }
}