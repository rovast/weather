# Weather

基于[高德开放平台](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)的天气 API 集成

> 此项目为测试项目，来自 [Laravel-China](https://laravel-china.org) 的 [《PHP 扩展包实战教程 - 从入门到发布》](https://laravel-china.org/courses/creating-package)
> 是个练习项目，请不要用于生产环境


## 安装

```shell
$ composer require rovast/weather -vvv
```

## 使用

```php
use Rovast\Weather\Weather;

$key = 'your-api-key';

$weather = new Weather($key);
```

## 在 Laravel 中使用

在 `config/services.php` 中配置
```php
'weather' => [
    'key' => env('WEATHER_API_KEY', 'your-api-key'),
],
```

两种方式调用

### 方法参数注入

```php
public function edit(Weather $weather) 
{
    $response = $weather->getWeather('深圳');
}
```

### 服务名访问

```php
public function edit() 
{
    $response = app('weather')->getWeather('深圳');
}
```

## License

MIT