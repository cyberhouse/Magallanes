<?php
namespace Mage\Command\Environment;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LockCommand
 */
class LockCommand extends EnvironmentCommand
{
    protected function configure()
    {
        $this->setName("environment:lock")
            ->setDescription("Locks the deployment to the given environment")
            ->setDefinition(array(
                new InputOption('name', 'e', InputOption::VALUE_REQUIRED, 'the name of the deployment environment', null)
            ))
            ->setHelp(<<<EOT
Locks the deployment to the given environment

Usage:
<info>bin/mage environment:lock --name="environment"</info>
or
<info>bin/mage environment:lock -e environment</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = $this->getIO();
        $environmentName = $input->getOption('name');

        if(empty($environmentName)) {
            return $this->error("the name parameter cannot be empty.");
        }

        $name = $io->ask('Your name', null);
        $email = $io->ask('Your E-Mail', null);
        $reason = $io->ask('Reason', null);

        $this->environmentHelper->lockEnvironment($environmentName, $name, $email, $reason);

        return $this->success("Locked deployment to environment $environmentName.");
    }
}