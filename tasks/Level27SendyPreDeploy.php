<?php
namespace Task;

use Mage\Task\AbstractTask;

class Level27SendyPreDeploy extends AbstractTask
{
    public function getName()
    {
        return 'Configuring your sendy installation';
    }

    public function run()
    {
        $currentFolder = $this->getConfig()->deployment('to');
        $url = $this->getConfig()->deployment('sendy_url');
        $dbName = $this->getConfig()->deployment('sendy_db_name');
        $dbUser = $this->getConfig()->deployment('sendy_db_user');
        $dbPass = $this->getConfig()->deployment('sendy_db_pass');

        $config = "<?php" . PHP_EOL .
            "define('APP_PATH', '" . $url . "');" . PHP_EOL .
            " \$dbHost = 'localhost'; " . PHP_EOL .
            " \$dbUser = '$dbUser'; " . PHP_EOL .
            " \$dbPass = '$dbPass'; " . PHP_EOL .
            " \$dbName = '$dbName'; " . PHP_EOL .
            " \$charset = 'utf8'; " . PHP_EOL .
            " \$dbPort = 3306;" . PHP_EOL .
            " define('COOKIE_DOMAIN', ''); " . PHP_EOL;
//        echo(getcwd());
        $localConfigPhp = getcwd() . '/includes/config.php';
        //echo($localConfigPhp);
        file_put_contents($localConfigPhp, $config);

        return true;

//        $result = $this->runCommandLocal('ls');
//        var_dump($result);
//        return $result;

//        throw new \Mage\Task\SkipException;
//        $service = $this->getParameter('name', false);

//        $command = "sudo /usr/sbin/service $service status";
//        $result = $this->runCommandRemote($command);
//
//        return $result;
    }




}