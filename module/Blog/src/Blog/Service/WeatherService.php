<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 25.07.2018
 * Time: 11:37
 */

namespace Blog\Service;


use GuzzleHttp\Client;

class WeatherService
{

    public function getCurrentTemp()
    {
        $client = new Client(['base_uri' => 'http://api.openweathermap.org/data/2.5/weather?q=Cologne&appid=921ea47346aa896378ec89dca17d3cf3&units=metric']);
        $response = $client->request('GET');
        $apiAsArray = json_decode($response->getBody(), true);

        //ToDo Hydrate = array zu Objekt(https://gist.github.com/Ocramius/5365052)

        return $apiAsArray['main']['temp'];
    }

}