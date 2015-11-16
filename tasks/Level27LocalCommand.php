<?php
namespace Task;

use Mage\Task\AbstractTask;

class Level27LocalCommand extends AbstractTask
{
    public function getName()
    {
        return 'Running command locally: ' . $this->getParameter('name', false);;
    }

    public function run()
    {
        $command = $this->getParameter('name', false);

        $result = $this->runCommandLocal($command);

        return $result;
    }
}