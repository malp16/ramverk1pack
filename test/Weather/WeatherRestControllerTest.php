<?php

namespace malp16\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test WeatherController
 */
class WeatherRestControllerTest extends TestCase
{
    protected $di;


    /**
     * set up di
     */
    protected function setUp()
    {
        global $di;

        //setup di

        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        //$di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        $this->di = $di;
    }
    /**
     * Test index action
     */
    public function testIndexAction()
    {
        $controller = new WeatherRestController();
        $controller->setDI($this->di);
        $res = $controller->indexAction("");
        $this->assertNotNull($res);
    }
    /**
     * Test coordinatesactionpost
     */
    public function testJsonActionPost()
    {
        $lon = "18.110103";
        $lat = "59.334415";

        $controller = new WeatherRestController();
        $controller->setDI($this->di);
        $request = $this->di->get("request");
        // test with forecast data
        $request->setPost("longitude", $lon);
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'forecast');
        $res = $controller->jsonActionPost();
        $this->assertNotNull($res);

        //test history data
        $request->setPost("radio", "history");
        $res = $controller->jsonActionPost();
        $this->assertNotNull($res);

        // test with incorrect data for forecast
        $request->setPost("longitude", "www");
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'forecast');
        $res = $controller->jsonActionPost();
        $this->assertNotNull($res);

        // test with incorrect data for history
        $request->setPost("longitude", $lon);
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'history');
        $res = $controller->jsonActionPost();
        $this->assertNotNull($res);
    }
    /**
    * Test jsonactionGet
    *
    **/
    public function testjsonActionGet()
    {
        $lon = "18.110103";
        $lat = "59.334415";
        $controller = new WeatherRestController();
        $controller->setDI($this->di);
        $request = $this->di->get("request");
        //$controller->setDI($di);

        $request->setGet("longitude", $lon);
        $request->setGet("latitude", $lat);
        $request->setGet("radio", 'history');

        $res = $controller->jsonActionGet();
        $this->assertNotNull($res);

        $request->setGet("radio", 'forecast');

        $res = $controller->jsonActionGet();
        $this->assertNotNull($res);


        // test with incorrect data
        $lon = "18.110103";
        $lat = "wrong";

        $request->setGet("longitude", $lon);
        $request->setGet("latitude", $lat);
        $request->setGet("radio", 'forecast');

        $res = $controller->jsonActionGet();
        $this->assertNotNull($res);
    }
    /**
     * Test infoActionpost
     */
    public function infoActionPost()
    {
        $controller = new WeatherRestController();
        $controller->setDI($this->di);

        $res = $controller->postActionPost();
        $this->assertNotNull($res);
    }
}
