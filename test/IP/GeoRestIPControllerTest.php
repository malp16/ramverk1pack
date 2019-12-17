<?php

namespace malp16\IP;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test GeoRestIPController
 */
class GeoRestIPControllerTest extends TestCase
{
    /**
     * Test the jsonActionGet.
     */
    public function testJsonActionGet()
    {
        $controller = new GeoRestIPController();
        $_GET["ip"] = "123.101.11.12";
        $res = $controller->jsonActionGet();
        $this->assertIsArray($res);

        $_GET["ip"] = "FE80:CD00:0000:0CDE:1257:0000:211E:729C";
        $res = $controller->jsonActionGet();
        $this->assertIsArray($res);

        $_GET["ip"] = "FE80:CD00:0000:0CDE:1257:0000:211E:729K";
        $res = $controller->jsonActionGet();
        $this->assertIsArray($res);
    }
}
