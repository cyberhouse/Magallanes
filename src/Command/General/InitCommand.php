<?php
namespace Mage\Command\General;

use Mage\Command\BaseCommand;
use Mage\Configuration\General;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InitCommand
 */
class InitCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName("init")
            ->setDescription("Initializes a new magallanes project")
            ->setDefinition(array(
                new InputOption('name', null, InputOption::VALUE_REQUIRED, 'the name of the project', null),
                new InputOption('email', null, InputOption::VALUE_OPTIONAL, 'email address of developer/maintainer', null)
            ))
            ->setHelp(<<<EOT
Initializes a new magallanes project

Usage:

<info>bin/mage init --name="My awesome project"</info>

You can additionally add the email option to set the notification email address
<info>bin/mage init --name="My awesome project" --email="foo@bar.com"</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = $this->getIO();

        $name = $input->getOption("name");

        $generalConfiguration = new General('general');

        if(empty($name)) {
            $io->error("The name of the project cannot be empty!");
            return 1;
        }

        $email = $input->getOption("email");
        $configDir = $generalConfiguration->getConfigurationDirectory();

        $io->text("Initiation managing process for application with Magallanes");

        // Check if there is already a config dir
        if (file_exists($configDir)) {
            return $this->error("Magallanes already initialized!");
        } else {
            $results   = array();
            $results[] = mkdir($configDir);
            $results[] = mkdir($configDir . '/logs');
            $results[] = file_put_contents($configDir . '/logs/.gitignore', "*\n!.gitignore");
            $results[] = mkdir($configDir . '/tasks');
            $results[] = touch($configDir . '/tasks/.gitignore');
            $results[] = mkdir($configDir . '/config');
            $results[] = mkdir($configDir . '/config/environment');
            $results[] = touch($configDir . '/config/environment/.gitignore');

            $generalConfiguration->initialize( array('name' => $name, 'email' => $email));

            $results[] = $generalConfiguration->save();
            if (!in_array(false, $results)) {
                return $this->success("The configuration for Magallanes has been generated in the .mage directory.");
            } else {
                return $this->error("Unable to generate the configuration.");
            }
        }
    }
}