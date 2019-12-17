<?php

namespace Anax\View;

?><h1> Se väder för en plats json </h1>

<p> Ange koordinater</p>


<form method="post" action="<?= url("restWeather/json") ?>">
    <label for="longitude">Longitude</label>
    <input type="text" value=<?= $longitude ?> name="longitude"><br>
    <label for="latitude">Latitude</label>
    <input type="text" value=<?= $latitude ?> name="latitude"><br>
    <input type="radio" name="radio" value="forecast" <?= $forecastRequest ?>">Prognos
    <input type="radio" name="radio" value="history" <?= $historyRequest ?>>Historik
    <input type="submit" name="getWeather" value="Sök"><br>
</form>
