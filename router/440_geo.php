<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Geographical ip-location",
            "mount" => "mingeo",
            "handler" => "\malp16\IP\GeoIPController",
        ],
    ]
];
