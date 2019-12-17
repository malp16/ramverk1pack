<?php

namespace malp16\IP;

/**
 * Test validity of IP-adress
 */
class IP
{

     // @var int $ip       IP-number to test.
     // @var bool $ipv4        valid according to ipv4 standard.
     // @var bool $ipv6        valid according to ipv6 standard.
     // @var string $webbAdress webbdomain if it exists.

     private $ip;       // IP-number to test.
     private $iPv4;        // valid according to ipv4 standard.
     private $iPv6;        // valid according to ipv6 standard.
     private $webbAdress; // valid according to ipv4 standard.
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
        if ($ip != null) {
            $this->setIPData();
        }
    }
    /**
     * set new ip, and reset values for ip-validity
     *
     */
    public function setNewIP($number)
    {
        $this->ip = $number;
        $this->setIPData();
    }
    /**
     * determines ip-validity according to ipv3 and ip6
     */
    private function setIPData()
    {
        if (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->iPv4="true";
        } else {
            $this->iPv4="false";
        }
        if (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->iPv6="true";
        } else {
            $this->iPv6="false";
        }
        if ($this->iPv4=="true" || $this->iPv6=="true") {
            $this->webbAdress = gethostbyaddr($this->ip);
        } else {
            $this->webbAdress = "na";
        }
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
    public function getIpv4()
    {
        return $this->iPv4;
    }
    /**
     * Get ipv6 validity
     *
     * @return string that is true or false.
     */
    public function getIpv6()
    {
        return $this->iPv6;
    }
    /**
     * Get webbadress
     *
     * @return string of domainname
     */
    public function getWebAdr()
    {
        return $this->webbAdress;
    }
    /**
     * Get statement of validity
     *
     * @return string that states if ip-adress is valid or not.
     */
    public function getStatement()
    {
        $myStatement = "";
        if ($this->iPv4 == "true") {
            $myStatement = "$this->ip är en giltig på formen ipv4.";
        } elseif ($this->iPv6 == "true") {
            $myStatement = "$this->ip är en giltig på formen ipv6.";
        } else {
            $myStatement = "$this->ip är en inte giltig på formen ipv4 eller ipv6.";
        }
        return $myStatement;
    }
    /**
     * Get validity data on jsonform
     *
     * @return array containing jsondata
     */
    public function getJsonArray()
    {
        $json = [
            "ip"=>$this->getIP(),
            "ipv4" =>$this->getIpv4(),
            "ipv6" =>$this->getIpv6(),
            "web" =>$this->getWebAdr(),
        ];

        return $json;
    }
}
