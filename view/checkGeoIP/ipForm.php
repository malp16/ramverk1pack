<?php

namespace Anax\View;

?><h1> Hitta plats </h1>

<p> Hitta en ip-adress fysiska plats</p>


<form method="post" action="<?= url("mingeo/") ?>">
    <input type="text" value=<?= $currentIP ?> name="ip">
     <input type="submit" name="performGeoCheck" value="Testa">
</form>

<!-- <?php
if (isset($_POST['ip'])) {
    $this->di->session->set("currentIP", $currentIP);
}
?> -->
