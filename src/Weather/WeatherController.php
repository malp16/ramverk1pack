<?php

namespace malp16\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A controller that displays weather information
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherController implements ContainerInjectableInterface
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
        $ipAdr = "0";
        $data = [
            "latitude"=> $lat,
            "longitude"=> $lon,
            "forecastRequest"=> $forecast,
            "historyRequest"=> $history,
            "ip"=> $ipAdr
        ];
        // $ip = $this->di->session->get("currentIP", null);
        //
        // $ipGeoCheck = new \malp16\IP\IPGeo($ip);
        // $myStatement = $ipGeoCheck->getStatement();
        //
        // if ($ip != null) {
        //     $ipData = [
        //        "content" => $myStatement,
        //        "currentIP"=>$ip
        //     ];
        // } else {
        //     $currentIP=$_SERVER['REMOTE_ADDR'];
        //     $ipData = [
        //        "content" => "Din egen adress ges som exempel.",
        //        "currentIP"=>$currentIP
        //     ];
        // }
        $page = $this->di->get("page");
        //$page->add("anax/v2/article/default", $data);
        $page->add("weatherGeo/weatherForm", $data);
        return $page->render();
    }
    public function useIPActionPost()
    {
        $request = $this->di->get("request");
        $ip = $request->getPost('ip');

        $myIP = new \malp16\IP\IPGeo($ip);

        if ($myIP->getLatitude() != null) {
            $lon = $myIP->getLongitude();
            $lat = $myIP->getLatitude();
            $forecast = 'echo checked="checked"';
            $history = '';
            //$ip = $myiP->;
            $data = [
                "latitude"=> $lat,
                "longitude"=> $lon,
                "forecastRequest"=> $forecast,
                "historyRequest"=> $history,
                "ip"=> $ip
            ];
            $page = $this->di->get("page");
            $page->add("weatherGeo/weatherForm", $data);
            return $page->render();
        } else {
            $lon = "0";
            $lat = "0";
            $forecast = 'echo checked="checked"';
            $history = '';
            //$ip = '';
            $data = [
                "latitude"=> $lat,
                "longitude"=> $lon,
                "forecastRequest"=> $forecast,
                "historyRequest"=> $history,
                "ip"=> $ip
            ];
            $page = $this->di->get("page");
            $page->add("weatherGeo/weatherForm", $data);
            $resp = "No coordinates availabel for this ip";
            $myData = [
                "content" => $resp
            ];
            $page->add("anax/v2/article/default", $myData);
            return $page->render();
        }
    }


    /**
     * This method displays weatherdata
     * POST mountpoint/coordinates
     *
     * @return string
     */
    public function coordinatesActionPost()
    {
        $request = $this->di->get("request");
        $lat = $request->getPost('latitude');
        $lon = $request->getPost('longitude');
        $radio = $request->getPost('radio');
        $ip = $request->getPost('ip');

        $darkSkyData = new DarkSkyData($lat, $lon, 30);
        //$weatherData = new WeatherGeo($darkSkyData);
        //$weatherData = new WeatherGeo();

        // get weathermodel from $di
        $weatherData = $this->di->get("weatherGeo");
        $weatherData->setDataProvider($darkSkyData);

        if ($weatherData->getValidResponse() == true) {
            $data = [
                "latitude"=> $weatherData->getLatitude(),
                "longitude"=> $weatherData->getLongitude(),
            ];
            if ($radio == "forecast") {
                $forecast = 'echo checked="checked"';
                $history = '';
                $data = [
                    "latitude"=> $weatherData->getLatitude(),
                    "longitude"=> $weatherData->getLongitude(),
                    "forecastRequest" => $forecast,
                    "historyRequest" => $history,
                    "ip" => $ip
                ];
                $page = $this->di->get("page");
                $page->add("weatherGeo/weatherForm", $data);
                $forecastArray = $weatherData->getArrayOfForecasts();
                foreach ($forecastArray as $dailycast) {
                    $myData = [
                        "content" => $dailycast
                    ];
                    $page->add("anax/v2/article/default", $myData);
                }
                $page->add("weatherGeo/map", $data);

                return $page->render();
            } else {
                $forecast = '';
                $history = 'echo checked="checked"';
                $data = [
                    "latitude"=> $weatherData->getLatitude(),
                    "longitude"=> $weatherData->getLongitude(),
                    "forecastRequest" => $forecast,
                    "historyRequest" => $history,
                    "ip" => $ip
                ];
                $historyArray = $weatherData->getArrayOfHistory();
                $page = $this->di->get("page");
                $page->add("weatherGeo/weatherForm", $data);
                $myDay ="";
                foreach ($historyArray as $dailycast) {
                    $myData = [
                        "content" => $dailycast
                    ];
                    $page->add("anax/v2/article/default", $myData);
                }
                $page->add("weatherGeo/map", $data);

                return $page->render();
            }
        } else {
            if ($radio == "forecast") {
                $forecast = 'echo checked="checked"';
                $history = '';
            } else {
                $forecast = '';
                $history = 'echo checked="checked"';
            }
            $data = [
                "latitude"=> $weatherData->getLatitude(),
                "longitude"=> $weatherData->getLongitude(),
                "forecastRequest" => $forecast,
                "historyRequest" => $history,
                "ip" => $ip
            ];
            $page = $this->di->get("page");
            $page->add("weatherGeo/weatherForm", $data);
            $resp = "No data available for these coordinates";
            $myData = [
                "content" => $resp
            ];
            $page->add("anax/v2/article/default", $myData);
            return $page->render();
        }
    }
}
