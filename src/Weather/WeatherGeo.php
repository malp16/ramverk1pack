<?php

namespace malp16\Weather;

/**
 * Get weatherdata from at weather data provider
 */
class WeatherGeo
{
    // @var array $myResult       weather forecast in arrat form
    // @var array $myHistory       weather history in array form
    // @var myWeatherDataProvider  class that connects to a server providing weatherdata

    private $myResult;
    private $myHistory;
    private $myWeatherDataProvider;

    // public function __construct()
    // {
    //     // $this->myWeatherDataProvider = $weatherData;
    //     // if ($this->myWeatherDataProvider->validResponse()) {
    //     //     $this->myResult = $weatherData->getWeatherResults();
    //     //     $this->myHistory = $weatherData->getWeatherHistory();
    //     //     //var_dump($this->myResult);
    //     // }
    // }
    /**
     * Constructor to that gets weatherdata from weatherdatafrom weatherdataprovider
     * sets myHistory and myResults if results are valid
     *
     * @param int $ip The current ip-address, null if not set
     *
     */
    public function setDataProvider($weatherData)
    {
        $this->myWeatherDataProvider = $weatherData;
        if ($this->myWeatherDataProvider->getValidResponse()) {
            $this->myResult = $weatherData->getWeatherResults();
            $this->myHistory = $weatherData->getWeatherHistory();
            //var_dump($this->myResult);
        }
    }
    public function getValidResponse()
    {
        return $this->myWeatherDataProvider->getValidResponse();
    }
    public function getArrayOfForecasts()
    {
        return $this->myWeatherDataProvider->getArrayOfForecasts();
    }

    public function getArrayOfHistory()
    {
        return $this->myWeatherDataProvider->getArrayOfHistory();
    }
    // /**
    //  * Get longitude
    //  *
    //  * @return string of longitude
    //  */
    public function getLongitude()
    {
        return $this->myWeatherDataProvider->getLongitude();
    }
    /**
     * Get latitude
     *
     * @return string of latitude
     */
    public function getLatitude()
    {
        return $this->myWeatherDataProvider->getLatitude();
    }
    /**
     * Get forecast data on jsonform
     *
     * @return array containing jsondata
     */
    public function getForecastJsonArray()
    {
        return $this->myWeatherDataProvider->getforecastJsonArray();
    }
    /**
     * Get history data on jsonform
     *
     * @return array containing jsondata
     */
    public function getHistoryJsonArray()
    {
        return $this->myWeatherDataProvider->getHistoryJsonArray();
    }
}
