<?php

namespace Rovast\Weather;

use GuzzleHttp\Client;

/**
 * Class Weather
 *
 * @package \Rovast\Weather
 */
class Weather
{
    protected $key;
    protected $guzzleOptions;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * 获取天气信息
     *
     * @param        $city
     * @param string $type
     * @param string $format
     * @return mixed|string
     * @author ROVAST
     */
    public function getWeather($city, string $type = 'base', string $format = 'json')
    {
        $url   = 'https://restapi.amap.com/v3/weather/weatherInfo?parameters';
        $query = array_filter([
            'key'        => $this->key,
            'city'       => $city,
            'extensions' => $type,
            'output'     => $format,
        ]);

        $response = $this->getHttpClient()->get($url, [
            'query' => $query,
        ])->getBody()->getContents();

        return 'json' === $format ? \json_decode($response) : $response;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }
}
