<?php
namespace Mage\Command\Environment;

/*
 * (c) 2011-2015 Andrés Montañez <andres@andresmontanez.com>
 * (c) 2016 by Cyberhouse GmbH <office@cyberhouse.at>
 *
 * This is free software; you can redistribute it and/or
 * modify it under the terms of the MIT License (MIT)
 *
 * For the full copyright and license information see
 * <https://opensource.org/licenses/MIT>
 */

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
        $this->setName('environment:remove')
            ->setDescription('Removes a deployment environment')
            ->setDefinition(
                [
                new InputOption('name', null, InputOption::VALUE_REQUIRED, 'the name of the deployment environment', null),
                ]
            )
            ->setHelp(
                <<<EOT
Removes deployment environment configuration

Usage:
<info>bin/mage environment:remove --name="stage"</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environmentName = $input->getOption('name');

        if (empty($environmentName)) {
            return $this->error('The name parameter cannot be empty.');
        }

        if ($this->environmentHelper->environmentExists($environmentName)) {
            if ($this->environmentHelper->removeEnvironment($environmentName)) {
                return $this->success("Environment $environmentName successfully removed.");
            } else {
                return $this->error("The environment \"$environmentName\" cannot be removed.");
            }
        } else {
            return $this->error("The environment \"$environmentName\" does not exist.");
        }
    }
}
