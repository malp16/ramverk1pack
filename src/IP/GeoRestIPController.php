<?php

namespace malp16\IP;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A controller thar returns jsondata about location
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GeoRestIPController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
    * Get location data on jsonform
    * takes input from $_GET and
    * returns json array
    *
    **/
    public function jsonActionGet() : array
    {
        $ip = $_GET["ip"] ?? null;
        $ipGeoCheck = new IPGeo($ip);

        $json = [ $ipGeoCheck->getJsonArray() ];
        return [$json];
    }
}
