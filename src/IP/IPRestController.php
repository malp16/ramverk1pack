<?php

//namespace Anax\Controller;
namespace malp16\IP;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IPRestController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // /**
    //  * Försök att efterlikna geomgångsvideo kmom01
    //  *
    //  * @return string
    //  */
    public function jsonActionGet() : array
    {
        $ip = $_GET["ip"] ?? null;
        $ipCheck = new IP($ip);

         $json = [ $ipCheck->getJsonArray() ];



        return [$json];
    }
    // /**
    //  * This sample method action takes one argument:
    //  * GET mountpoint/argument/<value>
    //  *
    //  * @param mixed $value
    //  *
    //  * @return string
    //  */
    //  public function argumentActionGet($value) : array
    // {
    //     //$ip = "127.0.0.1";
    //     $ip = $value;
    //     $ipCheck = new IP($ip);
    //
    //     $json = [ $ipCheck->getJsonArray() ];
    //
    //     return [$json];
    // }
}
