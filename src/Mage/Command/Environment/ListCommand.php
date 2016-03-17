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
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 */
class ListCommand extends EnvironmentCommand
{
    protected function configure()
    {
        $this->setName('environment:list')
            ->setDescription('Lists available deployment environments')
            ->setDefinition([])
            ->setHelp(
                <<<EOT
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

        if (empty($environments)) {
            $io->warning('There are no environment configurations available');
        } else {
            $io->title('Available environments');
            $io->listing($environments);
        }

        return $this->success();
    }
}
