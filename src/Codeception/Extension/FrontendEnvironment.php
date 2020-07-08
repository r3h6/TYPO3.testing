<?php

namespace R3H6\Typo3Testing\Codeception\Extension;

use Codeception\Events;
use Codeception\Extension;
use R3H6\Typo3Testing\Codeception\Module\MailHog;
use Symfony\Component\Filesystem\Filesystem;

class FrontendEnvironment extends Extension
{
    protected $config = [
        'test_root' => 'web/typo3temp/var/tests/acceptance',
        'files_to_link' => [
            'config' => 'config',
            'vendor' => 'vendor',
            'web/typo3' => 'web/typo3',
            'web/typo3conf' => 'web/typo3conf',
            'web/index.php' => 'web/index.php',
        ],
        'files_to_copy' => [
            'build/fixtures/fileadmin' => 'web/fileadmin',
            'build/fixtures/uploads' => 'web/uploads',
        ],
        'required_directories' => [
            'var',
            'web/fileadmin',
            'web/typo3temp',
            'web/typo3temp/assets',
            'web/typo3temp/var/transient',
            'web/uploads',
        ]
    ];

    protected static $events = array(
        Events::TEST_BEFORE => 'beforeTest',
    );


    public function beforeTest(\Codeception\Event\TestEvent $event)
    {
        // Setup test root
        $root = rtrim($this->config['test_root'], '/');
        $filesystem = new Filesystem();
        $filesystem->remove($root);
        $filesystem->mkdir($root);


        $this->getModule('\\R3H6\\Typo3Testing\\Codeception\\Module\\MailHog')->_setConfig(['test_root' => $root]);

        // Create symlinks
        $pwd = rtrim($_SERVER['PWD'], '/') . '/';
        $symlinks = (array) $this->config['files_to_link'];
        foreach ($symlinks as $target => $link) {
            $link = $pwd . $root . '/' . trim($link, '/');
            $target = $pwd . trim($target, '/');
            $filesystem->mkdir(dirname($link));
            if (!symlink($target, $link)) {
                throw new \RuntimeException('Could not create symlink');
            }
        }

        // Copy files
        $files = (array) $this->config['files_to_copy'];
        foreach ($files as $source => $target) {
            $source = rtrim($source, '/');
            $target = $root . '/' . trim($target, '/');
            if (is_dir($source)) {
                $filesystem->mirror($source, $target);
            } else {
                $filesystem->copy($source, $target);
            }
        }

        // Setup required directories
        $dirs = (array) $this->config['required_directories'];
        foreach ($dirs as $dir) {
            $dir = $root . '/' . trim($dir, '/');
            $filesystem->mkdir($dir);
        }
    }
}
