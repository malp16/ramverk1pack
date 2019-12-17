<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Marias geo-rest-ip controller.",
            "mount" => "restGeoIP",
            "handler" => "\malp16\IP\GeoRestIPController",
        ],
    ]
];
