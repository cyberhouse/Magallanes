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
 * Class AddCommand
 *
 * @author Johannes Pichler <johannes.pichler@cyberhouse.at>
 */
class AddCommand extends EnvironmentCommand
{

    protected function configure()
    {
        $this->setName('environment:add')
            ->setDescription('Adds a new deployment environment')
            ->setDefinition(
                [
                new InputOption('name', null, InputOption::VALUE_REQUIRED, 'the name of the deployment environment', null),
                new InputOption('enableReleases', 'r', InputOption::VALUE_OPTIONAL, 'flag for enabling releases', false),
                ]
            )
            ->setHelp(
                <<<EOT
Add new deployment environment configuration

Usage:

<info>bin/mage environment:add --name="stage"</info>

You can additionally add the enableReleases flag to enable release management for this environment.
<info>bin/mage environment:add --name="My awesome project" --enableReleases</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environmentName = $input->getOption('name');

        if (empty($environmentName)) {
            return $this->error('the name parameter cannot be empty.');
        }

        if ($this->environmentHelper->environmentExists($environmentName)) {
            return $this->error("the environment \"$environmentName\" already exists.");
        }

        $enableReleases = $input->getOption('enableReleases');

        $this->getIO()->text("Adding new environment: $environmentName");

        if ($this->environmentHelper->addEnvironment($environmentName, $enableReleases)) {
            return $this->success("Environment config file for $environmentName created successfully. Please review and adjust its configuration");
        } else {
            return $this->error("Unable to create configuration file for environment called $environmentName");
        }
    }
}
