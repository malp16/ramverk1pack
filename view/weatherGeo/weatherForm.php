<?php

namespace Anax\View;

?><h1> Se väder för en plats </h1>

<p> Ange ip-adress om du vill använda den för att hitta plats</p>
<form method="post" action="<?= url("weather/useIP") ?>">
    <label for="ip">IP</label>
    <input type="text" value=<?= $ip ?> name="ip"><br>
    <input type="submit" name="getlocationFromIp" value="Använd ip adress"><br>
</form> <br>

<p> Ange koordinater</p>
<form method="post" action="<?= url("weather/coordinates") ?>">
    <label for="longitude">Longitude</label>
    <input type="text" value=<?= $longitude ?> name="longitude"><br>
    <label for="latitude">Latitude</label>
    <input type="text" value=<?= $latitude ?> name="latitude"><br>
    <input type="radio" name="radio" value="forecast" <?= $forecastRequest ?>">Prognos
    <input type="radio" name="radio" value="history" <?= $historyRequest ?>>Historik
    <input type="hidden" name="ip" value="<?= $ip ?>">
    <input type="submit" name="getWeather" value="Sök"><br>
</form>
