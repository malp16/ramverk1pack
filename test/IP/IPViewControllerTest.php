<?php

namespace malp16\IP;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test IPController
 */
class IPViewControllerTest extends TestCase
{
    /**
     * Test the catchall.
     */


    public function testCatchAll()
    {
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        $controller = new IPViewController();
        $controller->setDI($di);

        $res = $controller->catchAll("ip=123.456.11.12");
        $this->assertNotNull($res);

        $_POST["ip"]="123.456.11.12";
        $res = $controller->catchAll("something");
        $this->assertNotNull($res);

        $_POST["ip"]=null;
        $res = $controller->catchAll();
        $this->assertNotNull($res);
    }
}
