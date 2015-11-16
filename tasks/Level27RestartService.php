<?php
namespace Task;

use Mage\Task\AbstractTask;

class Level27RestartService extends AbstractTask
{
    public function getName()
    {
        return 'Restarting service ' . $this->getParameter('name', false);;
    }

    public function run()
    {
        $service = $this->getParameter('name', false);

        $command = "sudo /usr/sbin/service $service restart";
        $result = $this->runCommandRemote($command);

        return $result;
    }
}