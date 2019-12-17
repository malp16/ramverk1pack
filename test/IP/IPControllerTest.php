<?php

namespace malp16\IP;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test IPController
 */
class IPControllerTest extends TestCase
{
    /**
     * Test the jsonActionPost.
     */
    public function testJsonActionPost()
    {
        $controller = new IPController();
        $res = $controller->jsonActionPost();
        $this->assertIsArray($res);
    }

    public function testArgumentActionGet()
    {
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        $controller = new IPController();
        $controller->setDI($di);

        $res = $controller->argumentActionGet("123.456.11.12");
        $this->assertNotNull($res);
    }

    public function testCatchAll()
    {
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        $controller = new IPController();
        $controller->setDI($di);

        $res = $controller->catchAll("ip=123.456.11.12");
        $this->assertNotNull($res);

        $_POST["ip"]="123.456.11.12";
        $res = $controller->catchAll();
        $this->assertNotNull($res);

        $_POST["ip"]=null;
        $res = $controller->catchAll();
        $this->assertNotNull($res);
    }
}
