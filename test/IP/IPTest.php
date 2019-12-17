<?php

namespace malp16\IP;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IPTest extends TestCase
{
    public function testIPv4Get()
    {
        $myIPCheck = new IP("129.144.50.36");
        $res= $myIPCheck->getIP();
        $this->assertIsString($res);
        $res= $myIPCheck->getStatement();
        $this->assertIsString($res);
    }
    public function testIPv6Get()
    {
        $myIPCheck = new IP("FE80:CD00:0000:0CDE:1257:0000:211E:729");
        $res= $myIPCheck->getIP();
        $this->assertIsString($res);
        $res= $myIPCheck->getStatement();
        $this->assertIsString($res);
    }
    public function testIPNeitherGet()
    {
        $myIPCheck = new IP("FE80:CD00:0000:0CDE:1257:0000:211E:72V");
        $res= $myIPCheck->getIP();
        $this->assertIsString($res);
        $res= $myIPCheck->getStatement();
        $this->assertIsString($res);
        $myIPCheck = $myIPCheck->setNewIP("FE80:CD00:0000:0CDE:1257:0000:211E:720");
        $this->assertIsString($res);
    }
}
