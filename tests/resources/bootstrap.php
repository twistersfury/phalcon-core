<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author    Phoenix <phoenix@twistersfury.com>
     * @license   http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    use Phalcon\Di;
    use Phalcon\Di\FactoryDefault;

    ini_set('display_errors',1);
    error_reporting(E_ALL);

    define('ROOT_PATH'  , realpath(__DIR__ . '/..'));
    define('SOURCE_PATH', realpath(ROOT_PATH . '/../src'));
    define('TEST_PATH'  , realpath(ROOT_PATH . '/src'));

    set_include_path(
        ROOT_PATH . PATH_SEPARATOR . get_include_path()
    );

    // Required for phalcon/incubator
    //include ROOT_PATH . "/../vendor/autoload.php";

    // Use the application autoloader to autoload the classes
    // Autoload the dependencies found in composer
    $loader = new \Phalcon\Loader();

    $loader->registerNamespaces(['TwistersFury\Phalcon\Core' => SOURCE_PATH]);

    $loader->registerDirs(
        array(
            ROOT_PATH
        )
    );

    if (FALSE) {
        $emLoader = new \Phalcon\Events\Manager();
        $emLoader->attach('loader', function (\Phalcon\Events\Event $phalconEvent, \Phalcon\Loader $loader) {
            if ($phalconEvent->getType() === 'beforeCheckPath') {
                echo $loader->getCheckedPath() . '<hr />';
            }
        });
        $loader->setEventsManager($emLoader);
    }

    $loader->register();

    $di = new FactoryDefault();
    Di::reset();

    // Add any needed services to the DI here

    Di::setDefault($di);