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

use Mage\Configuration\Environment;
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
        $this->setName('environment:unlock')
            ->setDescription('Unlocks the deployment to the given environment')
            ->setDefinition(
                [
                new InputOption('name', 'e', InputOption::VALUE_REQUIRED, 'the name of the deployment environment', null),
                ]
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

        if (empty($environmentName)) {
            return $this->error('the name parameter cannot be empty.');
        }

        if ($this->environmentHelper->unlockEnvironment($environmentName)) {
            return $this->success("Released deployment lock for environment $environmentName.");
        } else {
            return $this->error("Unable to release deployment lock for environment $environmentName.");
        }
    }
}
