<?php

namespace malp16\IP;

//require_once './data/ipStackKey.php';
/**
 * Test validity of IP-adress
 */
class IPGeo
{

     // @var int $ip       IP-number to test.
     // @var bool $ipv4        valid according to ipv4 standard.
     // @var bool $ipv6        valid according to ipv6 standard.
     // @var string $webbAdress webbdomain if it exists.
     // @var array $locationResults location info

     private $ip;       // IP-number to test.
     private $iPv4;        // valid according to ipv4 standard.
     private $iPv6;        // valid according to ipv6 standard.
     private $webbAdress; // valid according to ipv4 standard.
     private $locationResults; // array of results
    /**
     * Constructor to initiate the current ip-adress
     * set validity according to different standards
     *
     * @param int $ip The current ip-address, null if not set
     *
     */

    public function __construct($ip = null)
    {
        $this->ip = $ip;
        if ((filter_var($ip, FILTER_VALIDATE_IP))) {
            $this->getLocationDataFromIpStack($ip);
        } else {
            $this->locationResults =  null;
        }
    }
    /**
    * Get location data from ipstack
    *
    **/
    private function getLocationDataFromIpStack($myIp)
    {
        $myAccess = new IPGeoKey();
        $api_key=$myAccess->getIPStackKey();
        $ch = curl_init('http://api.ipstack.com/'.$myIp.'?access_key='.$api_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_data = curl_exec($ch);
        curl_close($ch);
        $result_data = json_decode($response_data, true);
        $this->locationResults = $result_data;
    }
    /**
     * Get ip-address
     *
     * @return string ip-adress
     */
    public function getIP()
    {
        return $this->ip;
    }
     /**
      * Get ipv4 validity
      *
      * @return string that is true or false.
      */
    public function getCountry()
    {
        return $this->locationResults["country_name"];
    }
    /**
     * Get nearest city
     *
    * @return string that is true or false.
    */
    public function getCity()
    {
        return $this->locationResults["city"];
    }
    /**
     * Get longitude
     *
     * @return string of longitude
     */
    public function getLongitude()
    {
        return $this->locationResults["longitude"];
    }
    /**
     * Get latitude
     *
     * @return string of latitude
     */
    public function getLatitude()
    {
        return $this->locationResults["latitude"];
    }
    /**
     * Get iptype
     *
     * @return string of iptype
     */
    public function getIpType()
    {
        if (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return "ipv4";
        } else if (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "ipv6";
        } else {
            return "not valid";
        }
    }
    /**
     * Get statement about location of ip adress
     *
     * @return string that states the location of an ip-adress.
     */
    public function getStatement()
    {
        $myStatement = "";
        if ((filter_var($this->ip, FILTER_VALIDATE_IP))) {
            $myStatement = $this->ip . " är av typ " . $this->getIpType() . ". Plats " . $this->getLatitude() . ", " . $this->getLongitude() . " " . $this->getCity() .  ", " .$this->getCountry();
        } else {
            $myStatement = $this->ip . " är inte giltig och har ingen plats.";
        }
        return $myStatement;
    }
    /**
     * Get location data on jsonform
     *
     * @return array containing jsondata
     */
    public function getJsonArray()
    {
        $json = [
            "ip"=>$this->getIP(),
            "ipType" =>$this->getIpType(),
            "latitude" =>$this->getLatitude(),
            "longitude" =>$this->getLongitude(),
            "city" =>$this->getCity(),
            "country" =>$this->getCountry(),
        ];
        return $json;
    }
}
