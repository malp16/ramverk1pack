<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Marias rest-weather controller.",
            "mount" => "restWeather",
            "handler" => "\malp16\Weather\WeatherRestController",
        ],
    ]
];
