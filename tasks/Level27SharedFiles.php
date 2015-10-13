<?php
namespace Task;

use Mage\Task\AbstractTask;

class Level27SharedFiles extends AbstractTask
{
    public function getName()
    {
        return 'Checking your shared folder';
    }

    public function run()
    {
        $sharedFile = $this->getParameter('sharedfile', false);
        if (strlen($sharedFile) > 0) {
            $sharedFolder = $this->getConfig()->deployment('to') . '/shared';
            $currentFolder = $this->getConfig()->deployment('to') . '/' . $this->getConfig()->release('directory', 'releases') . '/' . $this->getConfig()->getReleaseId();

            $file = $sharedFolder . trim($sharedFile);
            $symlink = $currentFolder . trim($sharedFile);


            $command = "ln -s $file $symlink";
            $result = $this->runCommandRemote($command);
        }

        return $result;
    }
}