<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Yaml\Dumper;


class MageinitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mage:init')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'The name of your great project')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'Your email address')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Initializing .mage folder in ' . getcwd() . '</info>');
        $output->writeln('Name: ' . $input->getOption('name'));
        $output->writeln('Email: ' . $input->getOption('email'));

        if (is_dir(getcwd() . '/.git') == false) {
            throw new Exception('This folder is not versioned in git. Are you in your project root folder?');
        }

        if (is_dir(getcwd() . '/.mage') == true) {
            throw new Exception('Mage is already initialized, please go to ' . getcwd() . '/.mage to see what is in there.');
        }

        // creating folders
        mkdir(getcwd() . '/.mage');
        mkdir(getcwd() . '/.mage/config');
        mkdir(getcwd() . '/.mage/config/environment');
        mkdir(getcwd() . '/.mage/logs');


        // assemble general.yml
        $array = array(
            'name' => $input->getOption('name'),
            'email' => $input->getOption('email'),
            'notifications' => 'false',
            'logging' => 'true',
            'maxlogs' => '30',
            'ssh_needs_tty' => 'false'
        );
        $dumper = new Dumper();
        $res = $dumper->dump($array, 1);
        var_dump($res);
        file_put_contents(getcwd() . '/.mage/config/general.yml', $res);

        // git add
        $this->executeCommand('git add .mage');

    }

    private function executeCommand($command, &$output = null)
    {
        $return = 1;
        exec($command . ' 2>&1', $log, $return);
        $log = implode(PHP_EOL, $log);

        if (!$return) {
            $output = trim($log);
        }
        return !$return;
    }

}