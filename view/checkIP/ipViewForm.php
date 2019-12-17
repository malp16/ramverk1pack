<?php

namespace Anax\View;

?><h1> Testa en ip-adress </h1>

<p> Test om en sträng är en giltig ip-adress</p>

<form method="post" action="<?= url("viewIP/") ?>">
    <input type="text" name="ip">
     <input type="submit" name="performCheck" value="Testa">
</form>
