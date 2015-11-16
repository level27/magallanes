<?php
namespace Task;

use Mage\Task\AbstractTask;

class Level27RemoteCommand extends AbstractTask
{
    public function getName()
    {
        return 'Running command remotely: ' . $this->getParameter('name', false);;
    }

    public function run()
    {
        $command = $this->getParameter('name', false);

        $result = $this->runCommandRemote($command);

        return $result;
    }
}