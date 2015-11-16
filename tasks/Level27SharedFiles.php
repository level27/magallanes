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

        if (strlen($sharedFile) == 0 || $sharedFile == '/')
            return;

        $sharedFolder = $this->getConfig()->deployment('to');
        if (strlen($this->getParameter('sharedfolder')))
            $sharedFolder = $this->getParameter('sharedfolder');

        if (strlen($sharedFile) > 0) {
        //    $sharedFolder = $this->getConfig()->deployment('to') . '/shared';
            $currentFolder = $this->getConfig()->deployment('to') . '/' . $this->getConfig()->release('directory', 'releases') . '/' . $this->getConfig()->getReleaseId();

            $file = $sharedFolder . trim($sharedFile);
            $symlink = $currentFolder . trim($sharedFile);

//            if (file_exists($symlink) == true) {
//                echo "$symlink EXISTS";
                $renamedsymlink = $symlink . '_RENAMED';
                if (strpos($symlink, '.') !== false) {
                    $renamedsymlink = substr($symlink, 0, strpos($symlink, '.')) .
                        '_RENAMED.' .
                        substr($symlink, strpos($symlink, '.') + 1);
                }
                $command = "mv $symlink $renamedsymlink";
                $result = $this->runCommandRemote($command);
//            }
//            else {
//                echo "$symlink DOES NOT EXIST";
//            }

            $command = "ln -s $file $symlink";
            $result = $this->runCommandRemote($command);
        }

        return $result;
    }
}