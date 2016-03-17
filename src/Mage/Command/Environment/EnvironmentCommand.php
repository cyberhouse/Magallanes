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
