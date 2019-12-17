<?php

namespace malp16\IP;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test IPController
 */
class GeoIPControllerTest extends TestCase
{
    public function testCatchAll()
    {
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        $controller = new GeoIPController();
        $controller->setDI($di);

        $controller->initialize();
        $_SERVER['REMOTE_ADDR']="194.47.151.11";
        $res = $controller->catchAll("something");

        $this->assertNotNull($res);

        $_SERVER['REMOTE_ADDR']='194.47.151.11';
        $_POST['performGeoCheck']=true;
        $_POST["ip"]="123.456.11.12";
        $res = $controller->catchAll("something");
        $this->assertNotNull($res);

        $_POST['performGeoCheck']=true;
        $_POST["ip"]="FE80:CD00:0000:0CDE:1257:0000:211E:729C";
        $res = $controller->catchAll();
        $this->assertNotNull($res);

        $_POST['performGeoCheck']=true;
        $_POST["ip"]=null;
        $res = $controller->catchAll();
        $this->assertNotNull($res);

        $_POST['performGeoCheck']=true;
        $_POST["ip"]="FE80:CD00:0000:0CDE:1257:0000:211E:729K";
        $res = $controller->catchAll("something");
        $this->assertNotNull($res);
    }
}
