<?php

namespace malp16\IP;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A IPController that tests ip-addresses
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IPViewController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

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
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $ip = $_POST["ip"] ?? null;
        //fungerar också men får ju ändå inte bort berondet av $_POST
        // if (isset($_POST['performCheck'])) {
        //     $this->di->session->set("ip", $_POST['ip']);
        // }
        $ipCheck = new IP($ip);

        if ($ip != null) {
            $data = [
                "content" => $ipCheck->getStatement()
            ];
        } else {
            $data = [
                "content" => null
            ];
        }

            $page->add("checkIP/ipViewForm");
            $page->add("anax/v2/article/default", $data);

            return $page->render();
    }
}
