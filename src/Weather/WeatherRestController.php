<?php

namespace malp16\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A controller that displays weather information on json form
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherRestController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * sets up default form data
     * coordinates for Stockholm
     * type of data requested: forecast
     * @return string
     */
    public function indexAction()
    {
        $lon = "18.110103";
        $lat = "59.334415";
        $forecast = 'echo checked="checked"';
        $history = '';
        $data = [
            "latitude"=> $lat,
            "longitude"=> $lon,
            "forecastRequest"=> $forecast,
            "historyRequest"=> $history
        ];
        $page = $this->di->get("page");
        $page->add("weatherGeo/weatherFormJson", $data);
        return $page->render();
    }
    // /**
    //  * Getting json data
    //  *
    //  * @return string
    //  */
    public function jsonActionGet() : array
    {
        $request = $this->di->get("request");
        $lat = $request->getGet('latitude');
        $lon = $request->getGet('longitude');
        $radio = $request->getGet('radio');


        //var_dump($lat);
        $darkSkyData = new DarkSkyData($lat, $lon, 30);
        // get weathermodel from $di
        $weatherData = $this->di->get("weatherGeo");
        $weatherData->setDataProvider($darkSkyData);

        //var_dump($weatherData->getForecastJsonArray());
        $json ="";
        if ($weatherData->getValidResponse() == true) {
            if ($radio == "forecast") {
                $json = [$weatherData->getForecastJsonArray() ];
            } else {
                $json = [ $weatherData->getHistoryJsonArray() ];
            }
        } else {
            $resp = "No data available for these coordinates";
            $json = [ [
                "content" => $resp ]
            ];
        }
        //var_dump($json);
        return $json;
    }

    public function jsonActionPost() : array
    {
        $request = $this->di->get("request");
        $lat = $request->getPost('latitude');
        $lon = $request->getPost('longitude');
        $radio = $request->getPost('radio');


        //var_dump($lat);
        $darkSkyData = new DarkSkyData($lat, $lon, 30);
        // get weathermodel from $di
        $weatherData = $this->di->get("weatherGeo");
        $weatherData->setDataProvider($darkSkyData);

        //var_dump($weatherData->getForecastJsonArray());
        $json ="";
        if ($weatherData->getValidResponse() == true) {
            if ($radio == "forecast") {
                $json = [$weatherData->getForecastJsonArray() ];
            } else {
                $json = [ $weatherData->getHistoryJsonArray() ];
            }
        } else {
            $resp = "No data available for these coordinates";
            $json = [ [
                "content" => $resp ]
            ];
        }
        //var_dump($json);
        return $json;
    }



    // /**
    //  * This method displays weatherdata
    //  * POST mountpoint/coordinates
    //  *
    //  * @return string
    //  */
    // public function coordinatesActionPost()
    // {
    //     $request = $this->di->get("request");
    //     $lat = $request->getPost('latitude');
    //     $lon = $request->getPost('longitude');
    //     $radio = $request->getPost('radio');
    //
    //     $darkSkyData = new DarkSkyData($lat, $lon, 3);
    //     //$weatherData = new WeatherGeo($darkSkyData);
    //     //$weatherData = new WeatherGeo();
    //
    //     // get weathermodel from $di
    //     $weatherData = $this->di->get("weatherGeo");
    //     $weatherData->setDataProvider($darkSkyData);
    //
    //     if ($weatherData->getValidResponse() == true) {
    //         $data = [
    //             "latitude"=> $weatherData->getLatitude(),
    //             "longitude"=> $weatherData->getLongitude(),
    //         ];
    //         if ($radio == "forecast")
    //         {
    //             $forecast = 'echo checked="checked"';
    //             $history = '';
    //             $data = [
    //                 "latitude"=> $weatherData->getLatitude(),
    //                 "longitude"=> $weatherData->getLongitude(),
    //                 "forecastRequest" => $forecast,
    //                 "historyRequest" => $history
    //             ];
    //             $page = $this->di->get("page");
    //             $page->add("weatherGeo/ipForm", $data);
    //             $forecastArray = $weatherData->getArrayOfForecasts();;
    //             foreach($forecastArray as $dailycast) {
    //                 $myData = [
    //                     "content" => $dailycast
    //                 ];
    //                 $page->add("anax/v2/article/default", $myData);
    //             }
    //             $page->add("weatherGeo/map", $data);
    //
    //             return $page->render();
    //         } else {
    //             $forecast = '';
    //             $history = 'echo checked="checked"';
    //             $data = [
    //                 "latitude"=> $weatherData->getLatitude(),
    //                 "longitude"=> $weatherData->getLongitude(),
    //                 "forecastRequest" => $forecast,
    //                 "historyRequest" => $history
    //             ];
    //             $historyArray = $weatherData->getArrayOfHistory();
    //             $page = $this->di->get("page");
    //             $page->add("weatherGeo/ipForm", $data);
    //             $myDay ="";
    //             foreach($historyArray as $dailycast) {
    //                 $myData = [
    //                     "content" => $dailycast
    //                 ];
    //                 $page->add("anax/v2/article/default", $myData);
    //             }
    //             $page->add("weatherGeo/map", $data);
    //
    //             return $page->render();
    //         }
    //     }
    //     else {
    //         if ($radio == "forecast") {
    //             $forecast = 'echo checked="checked"';
    //             $history = '';
    //         } else {
    //             $forecast = '';
    //             $history = 'echo checked="checked"';
    //         }
    //         $data = [
    //             "latitude"=> $weatherData->getLatitude(),
    //             "longitude"=> $weatherData->getLongitude(),
    //             "forecastRequest" => $forecast,
    //             "historyRequest" => $history
    //         ];
    //         $page = $this->di->get("page");
    //         $page->add("weatherGeo/ipForm", $data);
    //         $resp = "No data available for these coordinates";
    //         $myData = [
    //             "content" => $resp
    //         ];
    //         $page->add("anax/v2/article/default", $myData);
    //         return $page->render();
    //
    //     }
    //}
}
