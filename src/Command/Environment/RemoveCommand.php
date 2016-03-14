<?php
namespace Mage\Command\Environment;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RemoveCommand
 */
class RemoveCommand extends EnvironmentCommand
{
    protected function configure()
    {
        $this->setName("environment:remove")
            ->setDescription("Removes a deployment environment")
            ->setDefinition(array(
                new InputOption('name', null, InputOption::VALUE_REQUIRED, 'the name of the deployment environment', null)
            ))
            ->setHelp(<<<EOT
Removes deployment environment configuration

Usage:
<info>bin/mage environment:remove --name="stage"</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environmentName = $input->getOption('name');

        if(empty($environmentName)) {
            return $this->error("The name parameter cannot be empty.");
        }

        if($this->environmentHelper->environmentExists($environmentName)) {
            if($this->environmentHelper->removeEnvironment($environmentName)) {
                return $this->success("Environment $environmentName successfully removed.");
            }
            else {
                return $this->error("The environment \"$environmentName\" cannot be removed.");
            }
        }
        else {
            return $this->error("The environment \"$environmentName\" does not exist.");
        }
    }
}