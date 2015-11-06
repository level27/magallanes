<?php
namespace Task;

use Mage\Task\AbstractTask;

class Level27PreDeploy extends AbstractTask
{
    public function getName()
    {
        return 'Checking pre-deployment status of your server.';
    }

    public function run()
    {
        if (is_dir($this->getConfig()->deployment('to')) == false) {
            $command = "mkdir " . $this->getConfig()->deployment('to');
            $result = $this->runCommandRemote($command);
        }
    }
}