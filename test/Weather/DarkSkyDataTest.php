<?php

namespace malp16\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test DarkSkyData connection
 */
class DarkSkyDataTest extends TestCase
{
    /**
     * Test validity of reponse
     */
    public function testValidResponse()
    {
        // test using valid data
        $lon = "18.110103";
        $lat = "59.334415";
        $myDarkSkyData = new DarkSkyData($lat, $lon, 3);
        $res= $myDarkSkyData->getValidResponse();
        $this->assertTrue($res);

        // test using invalid data
        $lon = "wrong";
        $lat = "59.334415";
        $myDarkSkyData = new DarkSkyData($lat, $lon, 3);
        $res= $myDarkSkyData->getValidResponse();
        $this->assertFalse($res);
    }
    /**
     * Test getting forecast cata on array form
     */
    public function testGetForecastJsonArray()
    {
        $lon = "18.110103";
        $lat = "59.334415";
        $myDarkSkyData = new DarkSkyData($lat, $lon, 3);
        $res= $myDarkSkyData->getForecastJsonArray();
        $this->assertIsArray($res, true);
    }
    /**
     * Test getting history data on array form
     */
    public function testGetHistoryJsonArray()
    {
        $lon = "18.110103";
        $lat = "59.334415";
        $myDarkSkyData = new DarkSkyData($lat, $lon, 3);
        $res= $myDarkSkyData->getHistoryJsonArray();
        $this->assertIsArray($res, true);
    }
}
