<?php

namespace malp16\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test WeatherGeo.
 */
class WeatherGeoTest extends TestCase
{
    /**
     * Test if response is valid
     */
    public function testValidResponse()
    {
        // test using valid data
        $myWeatherGeo = new WeatherGeo();
        $lon = "18.110103";
        $lat = "59.334415";
        $myDarkSkyData = new DarkSkyData($lat, $lon, 3);
        $myWeatherGeo->setDataProvider($myDarkSkyData);
        $res= $myWeatherGeo->getValidResponse();
        $this->assertTrue($res);

        // test using invalid data
        $myWeatherGeo = new WeatherGeo();
        $lon = "wrong";
        $lat = "59.334415";
        $myDarkSkyData = new DarkSkyData($lat, $lon, 3);
        $myWeatherGeo->setDataProvider($myDarkSkyData);
        $res= $myWeatherGeo->getValidResponse();
        $this->assertFalse($res);
    }
    /**
     * Test getting weather forecast on array form
     */
    public function testGetForecastJsonArray()
    {
        $myWeatherGeo = new WeatherGeo();
        $lon = "18.110103";
        $lat = "59.334415";
        $myDarkSkyData = new DarkSkyData($lat, $lon, 3);
        $myWeatherGeo->setDataProvider($myDarkSkyData);
        $res= $myWeatherGeo->getForecastJsonArray();
        $this->assertIsArray($res, true);
    }
    /**
     * Test getting weather hsitory on array form
     */
    public function testGetHistoryJsonArray()
    {
        $myWeatherGeo = new WeatherGeo();
        $lon = "18.110103";
        $lat = "59.334415";
        $myDarkSkyData = new DarkSkyData($lat, $lon, 3);
        $myWeatherGeo->setDataProvider($myDarkSkyData);
        $res= $myWeatherGeo->getHistoryJsonArray();
        $this->assertIsArray($res, true);
    }
}
