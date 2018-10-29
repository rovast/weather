<?php

namespace Rovast\Weather;

use GuzzleHttp\Client;
use Rovast\Weather\Exceptions\HttpException;
use Rovast\Weather\Exceptions\InvalidArgumentException;


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
     * @param        $city
     * @param string $type
     * @param string $format
     * @return mixed|string
     * @throws \Rovast\Weather\Exceptions\HttpException
     * @throws \Rovast\Weather\Exceptions\InvalidArgumentException
     * @author ROVAST
     */
    public function getWeather($city, string $type = 'base', string $format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo?parameters';

        if (!\in_array(\strtolower($format), ['xml', 'json'])) {
            throw new InvalidArgumentException('Invalid response format: ' . $format);
        }

        if (!\in_array(\strtolower($type), ['base', 'all'])) {
            throw new InvalidArgumentException('Invalid type value(base/all): ' . $type);
        }

        $query = array_filter([
            'key'        => $this->key,
            'city'       => $city,
            'extensions' => \strtolower($type),
            'output'     => \strtolower($format),
        ]);

        try {
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
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
