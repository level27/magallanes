<?php
namespace Task;

use Mage\Task\AbstractTask;

class Level27Drush extends AbstractTask
{
    public function getName()
    {
        $str = 'Executing drush ' . $this->getParameter('params', false);
        if (strlen($this->getParameter('workingdir')))
            $str .= ' in ' . $this->getParameter('workingdir');

        return $str;
    }


    public function run()
    {
        $params = $this->getParameter('params', false);
        if (strlen($params) > 0) {
            $currentdir = $this->getConfig()->deployment('to') . '/' . $this->getConfig()->release('directory', 'releases') . '/' . $this->getConfig()->getReleaseId();

            $workingdir = trim($this->getParameter('workingdir'));
            if ($workingdir == '')
                $workingdir = '/';

            $command = "cd $currentdir$workingdir && drush $params";
            $result = $this->runCommandRemote($command);
        }

        return $result;
    }
}