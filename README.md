# Redovisasida

Min redovisa sida i kursen ramverk1

## Om sidan

Denna sida är byggd i anax och består av ett antal kontroller som kan testa ip-adresser

## Tester

Det finns tester som testar om kontrollklasserna fungerar.

## Byggt med

* [Anax](https://github.com/canax/) - Ett php ramverk

## Rest API

För att komma åt väderdata på json-format behöver man ange
latitud, longitud och om man vill ha en prognos för framtiden
eller om man vill ha väderhistorik.

### Exempel på adress för att få Väderprognos

htdocs/restWeather/json?longitude=18.110103&latitude=59.334415&radio=forecast

### Exempel på adress för Väderhistorik

htdocs/restWeather/json?longitude=18.110103&latitude=59.334415&radio=history
