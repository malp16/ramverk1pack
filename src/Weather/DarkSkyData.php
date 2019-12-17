<?php

namespace malp16\Weather;

/**
 * Get weatherdata from Dark Sky
 */
class DarkSkyData
{
    // @var string $latitude      latitude
    // @var string $longitude     longitude
    // @var array $myResult       weather forecast in arrat form
    // @var array $myHistory      weather history in array form

    private $latitude;
    private $longitude;
    private $myResult;
    private $myHitory;


    /**
     * Constructor to connect to Dark sky api and get weather data
     * set validity according to different standards
     *
     * @param string $lat latitude
     * @param string $lon longitude
     * @param string $numberOfDays  - how many past days of weather history
     *
     */
    public function __construct($lat, $lon, $numberOfDays)
    {
        $this->latitude = $lat;
        $this->longitude = $lon;
        $this->getDarkSkyData($lat, $lon);
        $this->getDarkSkyHistory($lat, $lon, $numberOfDays);
    }
     /**
     * Get weather forecast in array form
     *
     **/
    public function getWeatherResults()
    {
        return $this->myResult;
    }
     /**
     * Get weather history in array form
     *
     **/
    public function getWeatherHistory()
    {
        return $this->myHistory;
    }
     /**
     * Get weather forecast data from darksky
     *
     **/
    private function getDarkSkyData($lat, $lon)
    {
        $secrets = require(ANAX_INSTALL_PATH . "/config/secrets.php");
        $darkApiKey =  $secrets["darkSkyApiKey"];
        $darkURL ="https://api.darksky.net/forecast/$darkApiKey/$lat,$lon";
        $ch = curl_init($darkURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_data = curl_exec($ch);
        curl_close($ch);
        $result_data = json_decode($response_data, true);
        $this->myResult = $result_data;
    }
     /**
     * Get array of last number of days
     *
     **/
    private function getLastDays($numberOfDays)
    {
        $lastDays = array();
        for ($i = 0; $i <= $numberOfDays; $i++) {
            $day = time();
            array_push($lastDays, $day - ($i * 24 * 60 * 60));
        }
        return $lastDays;
    }
     /**
     * Get weather history data from darksky
     *
     **/
    private function getDarkSkyHistory($lat, $lon, $numberOfDays)
    {
        $secrets = require(ANAX_INSTALL_PATH . "/config/secrets.php");
        $darkApiKey = $secrets["darkSkyApiKey"];
        $darkURL ="https://api.darksky.net/forecast/$darkApiKey/$lat,$lon";
        $lastDays = $this->getLastDays($numberOfDays); //ändra här för att minska antalet anrop

        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];
         // Add all curl handlers and remember them
         // Initiate the multi curl handler
        $mh = curl_multi_init();
        $chAll = [];
         //foreach ($userIds as $id) {
        foreach ($lastDays as $day) {
            $ch = curl_init("$darkURL,$day");
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }
         // Execute all queries simultaneously,
         // and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
         // Close the handles
        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
         // All of our requests are done, we can now access the results
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);
        }
         $this->myHistory = $response;
    }
     /*
     * Test if response frpm dark sky is valid
     */
    public function getValidResponse()
    {
        if (array_key_exists("code", $this->myResult) && ($this->myResult['code'] == 400)) {
            return false;
        } else {
            return true;
        }
    }
     /*
     * get array of weather forecasts
     */
    public function getArrayOfForecasts()
    {
        $myForecastData = $this->myResult["daily"]["data"];
        $myForecastArray = array();
        foreach ($myForecastData as $myDay) {
            $weatherStatement= date('Y-m-d', $myDay["time"]) . " " . $myDay["summary"];
            array_push($myForecastArray, $weatherStatement);
        }
        return $myForecastArray;
    }

     /*
     * get array of weather history
     */
    public function getArrayOfHistory()
    {
        $myForecastData = $this->myHistory;
        $myForecastArray = array();
        foreach ($myForecastData as $myDay) {
            $myHistoryArray = array();
            $weatherStatement = date('Y-m-d', $myDay["currently"]["time"]) . " " . $myDay["currently"]["summary"];
            array_push($myForecastArray, $weatherStatement);
        }
         //$myForecastArray= $this->myHistory[2]["timezone"]; //ger Stockholm/Europe
        return $myForecastArray;
    }
      /**
      * Get longitude
      *
      * @return string of longitude
      */
    public function getLongitude()
    {
         return $this->longitude;
        // return $this->myResult["longitude"];
    }
     /**
      * Get latitude
      *
      * @return string of latitude
      */
    public function getLatitude()
    {
        return $this->latitude;
         //return $this->locationResults["latitude"];
    }
     /**
      * Get waether forecast data on jsonform
      *
      * @return array containing jsondata
      */
    public function getForecastJsonArray()
    {
        $myForecastData = $this->myResult["daily"]["data"];
        $myForecastArray = array();
        foreach ($myForecastData as $myDay) {
            $myDate = date('Y-m-d', $myDay["time"]);
            $mySummary = $myDay["summary"];
            $myArrayPost = array(
            "latitude"=>$this->latitude,
            "longitude"=>$this->longitude,
            "date"=>$myDate,
            "summary"=>$mySummary);

            array_push($myForecastArray, $myArrayPost);
        }
        //return json_encode($myForecastArray);
        return $myForecastArray;
    }

    /**
      * Get weather history data on jsonform
     *
     * @return array containing jsondata
     */
    public function getHistoryJsonArray()
    {
        $myHistoryData = $this->myHistory;
        //var_dump($myHistoryData);
        $myHistoryArray = array();
        foreach ($myHistoryData as $myDay) {
            $myDate = date('Y-m-d', $myDay["currently"]["time"]);
            $mySummary = $myDay["currently"]["summary"];
            $myArrayPost = array(
            "latitude"=>$this->latitude,
            "longitude"=>$this->longitude,
            "date"=>$myDate,
            "summary"=>$mySummary);

            array_push($myHistoryArray, $myArrayPost);
        }
        // return json_encode($myHistoryArray);
        //var_dump($myHistoryArray);
        return $myHistoryArray;
    }
}
