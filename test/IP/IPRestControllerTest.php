<?php

namespace malp16\IP;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test IPRestController
 */
class IPRestControllerTest extends TestCase
{
    /**
     * Test the jsonActionGet.
     */
    public function testJsonActionGet()
    {
        $controller = new IPRestController();
        //$controller->initialize();
        $_GET["ip"] = "123.101.11.12";
        $res = $controller->jsonActionGet();
        $this->assertIsArray($res);
    }
}
