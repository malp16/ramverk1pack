<?php

namespace malp16\IP;

/**
 * Get access key for ipstack
 */
class IPGeoKey
{

    private $api_access_key = 'ff3d0a8e1237ee2a28837ca3e0c4a3a7';

    public function getIPStackKey()
    {
        return $this->api_access_key;
    }
}
