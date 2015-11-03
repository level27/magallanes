<?
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
use Symfony\Component\Yaml\Parser;


class MageinitenvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mage:initenv')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Name of the environment')
            ->addOption('hosts', null, InputOption::VALUE_REQUIRED, 'Host or hosts, if more use comma to separate')
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'SSH user to deploy')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Updating environment in ' . getcwd() . '</info>');
        $output->writeln('Name: ' . $input->getOption('name'));
        $output->writeln('Hosts: ' . $input->getOption('hosts'));
        $output->writeln('User: ' . $input->getOption('user'));

        if (is_dir(getcwd() . '/.git') == false) {
            throw new Exception('This folder is not versioned in git. Are you in your project root folder?');
        }

        if (is_dir(getcwd() . '/.mage') == false) {
            throw new Exception('Mage is not initialized. Please do mage:init first.');
        }

        $configfilename = getcwd() . '/.mage/config/environment/' . $input->getOption('name') . '.yml';
        $config = array();
        if (file_exists($configfilename)) {
            $parser = new Parser();
            $config = $parser->parse(file_get_contents($configfilename));
        }
        else {
            // read template in config
            $mydir = dirname(__FILE__);
            $parser = new Parser();
            $config = $parser->parse(file_get_contents($mydir . '/../Resources/template.yml'));
        }

        var_dump($config);
        $config['deployment']['user'] = $input->getOption('user');
        $config['deployment']['to'] = '/var/web/' . $input->getOption('user') . '/deploy';
        $hosts = explode(',', $input->getOption('hosts'));
        $config['hosts'] = $hosts;
        $dumper = new Dumper();
        $res = $dumper->dump($config, 3);
        var_dump($res);
        file_put_contents($configfilename, $res);

        // git add
        $this->executeCommand('git add ' . $configfilename);

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