<?php

namespace Test\Phpunit;

use Phalcon\Di;
//use Phalcon\Test\UnitTestCase as PhalconTestCase;
use \Phalcon\Test\PHPUnit\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase
{
    /**
     * @var bool
     */
    private $_loaded = false;

    public function setUp()
    {
        parent::setUp();


        // Load any additional services that might be required during testing
        $di = Di::getDefault();

        // Get any DI components here. If you have a config, be sure to pass it to the parent
        $di->setShared('config', []);

        $di->setShared('request', function () {
            return new \Phalcon\Http\Request;
        });
        $di->setShared('response', function () {
            return new \Phalcon\Http\Response;
        });
        $di->setShared('filter', function () {
            return new \Phalcon\Filter;
        });
        $di->setShared('filter', function () {
            return new \Phalcon\Filter;
        });
        $di->setShared('modelsManager', function () {
            return new \Phalcon\Mvc\Model\Manager();
        });
        $di->setShared('modelsMetadata', function () {
            return new \Phalcon\Mvc\Model\Metadata\Memory();
        });
        $di->set('db', function () {
            return new \Phalcon\Db\Adapter\Pdo\Sqlite();
        });


        $this->setDi($di);
        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            /*throw new \PHPUnit_Framework_IncompleteTestError(
                "Please run parent::setUp()."
            );*/
            parent::setUp();
        }
    }
}

