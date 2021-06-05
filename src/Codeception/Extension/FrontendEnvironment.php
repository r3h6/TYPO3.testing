<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Extension;

use Codeception\Events;
use Codeception\Extension;
use R3H6\Typo3Testing\Codeception\Module\MailHog;
use Symfony\Component\Filesystem\Filesystem;

class FrontendEnvironment extends Extension
{
    /**
     * @var array
     */
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
            'build/fixtures/acceptance/fileadmin' => 'web/fileadmin',
            'build/fixtures/acceptance/uploads' => 'web/uploads',
        ],
        'required_directories' => [
            'var',
            'web/fileadmin',
            'web/typo3temp',
            'web/typo3temp/assets',
            'web/typo3temp/var/transient',
            'web/uploads',
        ],
        'additional_configuration' => [
            'BE' => [
                'debug' => true,
            ],
            'FE' => [
                'debug' => true,
                'lockIP' => 0,
            ],
            'SYS' => [
                'trustedHostsPattern' => '.*',
                'devIPmask' => '*',
                'displayErrors' => 1,
                // 'exceptionalErrors' => 22519, // E_ALL ^ E_DEPRECATED ^ E_NOTICE,
                'sqlDebug' => 1,
                'systemLog' => '',
                'systemLogLevel' => 0,
            ],
            'GFX' => [
                'processor' => 'ImageMagick',
                'processor_path' => '/usr/bin/',
                'processor_path_lzw' => '/usr/bin/',
            ],
            'MAIL' => [
                'transport' => 'smtp',
                'transport_smtp_server' => 'mail:1025'
            ],
            'DB' => [
                'Connections' => [
                    'Default' => [
                        'dbname' => 'db',
                        'host' => 'db',
                        'password' => 'db',
                        'port' => '3306',
                        'user' => 'db',
                    ],
                ],
            ],
        ],
    ];

    /**
     * @var string[]
     */
    protected static $events = [
        Events::TEST_BEFORE => 'beforeTest',
    ];

    public function beforeTest(\Codeception\Event\TestEvent $event): void
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

        $additionalConfigurationFile = $root . '/web/typo3conf/AdditionalConfiguration.php';
        if (!$filesystem->exists($additionalConfigurationFile)) {
            // $db = $this->getModule('DB');
            $additionalConfiguration = $this->config['additional_configuration'];
            $content = "<?php\n"
                . "\$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(\$GLOBALS['TYPO3_CONF_VARS'], "
                . var_export($additionalConfiguration, true)
                . ");";
            $filesystem->dumpFile($additionalConfigurationFile, $content);
        }
    }
}
