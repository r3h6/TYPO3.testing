<?php

namespace R3H6\Typo3Testing\Codeception\Extension;

use Codeception\Events;
use Codeception\Extension;
use Symfony\Component\Filesystem\Filesystem;

class FrontendEnvironment extends Extension
{
    protected static $events = array(
        Events::TEST_BEFORE => 'beforeTest',
    );

    public function beforeTest(\Codeception\Event\TestEvent $event)
    {
        // docker-compose -f build/docker/acceptance.yml down
        // return;

        $root = 'web/typo3temp/tests/acceptance';

        $filesystem = new Filesystem();
        $filesystem->remove($root);
        $filesystem->mkdir($root);

        $filesystem->mirror('build/fixtures', $root . '/web');

        $dirs = [
            'var',
            'web/typo3temp',
            'web/typo3temp/assets',
            'web/typo3temp/var/transient'
        ];

        foreach ($dirs as $dir) {
            $filesystem->mkdir($root . '/' . $dir);
        }

        $symlinks = [
            'config',
            'vendor',
            'web/typo3',
            'web/typo3conf',
            'web/index.php',
        ];

        $pwd = rtrim($_SERVER['PWD'], '/') . '/';
        foreach ($symlinks as $symlink) {
            $link = $pwd . $root . '/' . $symlink;
            $target = $pwd . $symlink;
            if (!symlink($target, $link)) {
                throw new \RuntimeException('Could not create symlink');
            }
        }

        // $copies = [
        //     'web/index.php',
        // ];

        // foreach ($copies as $copy) {
        //     $filesystem->copy($copy, $webroot . '/' . $copy, true);
        // }
    }
}
