<?php

namespace malp16\IP;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GeoIPController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function initialize()
    {
        $session = $this->di->get("session");
        $this->di->session->delete("currentIP");
    }

    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. YOu can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
        if (isset($_POST['performGeoCheck'])) {
            $this->di->session->set("currentIP", $_POST['ip']);
        }
        $ip = $this->di->session->get("currentIP", null);

        $ipGeoCheck = new IPGeo($ip);
        $myStatement = $ipGeoCheck->getStatement();

        if ($ip != null) {
            $data = [
               "content" => $myStatement,
               "currentIP"=>$ip
            ];
        } else {
            $currentIP=$_SERVER['REMOTE_ADDR'];
            $data = [
               "content" => "Din egen adress ges som exempel.",
               "currentIP"=>$currentIP
            ];
        }

        $page = $this->di->get("page");
        $page->add("checkGeoIP/ipForm", $data);
        $page->add("anax/v2/article/default", $data);

        return $page->render();
    }
}
