<?php

namespace malp16\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test WeatherController
 */
class WeatherControllerTest extends TestCase
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
        $controller = new WeatherController();
        $controller->setDI($this->di);
        $res = $controller->indexAction("");
        $this->assertNotNull($res);
    }
    /**
     * Test coordinatesactionpost
     */
    public function testCoordinatesActionPost()
    {
        $lon = "18.110103";
        $lat = "59.334415";

        $controller = new WeatherController();
        $controller->setDI($this->di);
        $request = $this->di->get("request");
        // test with forecast data
        $request->setPost("longitude", $lon);
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'forecast');
        $res = $controller->coordinatesActionPost();
        $this->assertNotNull($res);

        //test history data
        $request->setPost("radio", "history");
        $res = $controller->coordinatesActionPost();
        $this->assertNotNull($res);

        // test with incorrect data for forecast
        $request->setPost("longitude", "www");
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'forecast');
        $res = $controller->coordinatesActionPost();
        $this->assertNotNull($res);

        // test with incorrect data for history
        $request->setPost("longitude", "www");
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'history');
        $res = $controller->coordinatesActionPost();
        $this->assertNotNull($res);
    }
    public function testuseIPActionPost()
    {
        $lon = "18.110103";
        $lat = "59.334415";
        $ip = "121.111.11.22";

        $controller = new WeatherController();
        $controller->setDI($this->di);
        $request = $this->di->get("request");
        // test with forecast data
        $request->setPost("longitude", $lon);
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'forecast');
        $request->setPost("ip", $ip);
        $res = $controller->useIPActionPost();
        $this->assertNotNull($res);

        //test history data
        $request->setPost("radio", "history");
        $res = $controller->useIPActionPost();
        $this->assertNotNull($res);

        // test with incorrect geographical data for forecast
        $request->setPost("longitude", "www");
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'forecast');
        $res = $controller->useIPActionPost();
        $this->assertNotNull($res);

        // test with incorrect geographical data for history
        $request->setPost("longitude", "www");
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'history');
        $request->setPost("ip", $ip);
        $res = $controller->useIPActionPost();
        $this->assertNotNull($res);

        // Test with incirrect data for ip
        $lon = "18.110103";
        $lat = "59.334415";
        $ip = "12k.111.11.22";
        $request->setPost("longitude", $lon);
        $request->setPost("latitude", $lat);
        $request->setPost("radio", 'forecast');
        $request->setPost("ip", $ip);
        $res = $controller->useIPActionPost();
        $this->assertNotNull($res);
    }
    /**
     * Test infoActionpost
     */
    public function infoActionPost()
    {
        $controller = new WeatherController();
        $controller->setDI($this->di);

        $res = $controller->postActionPost();
        $this->assertNotNull($res);
    }
}
