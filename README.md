# Geo location service package

[![Build Status](https://travis-ci.org/PanovAlexey/geo-location.svg?branch=master)](https://travis-ci.org/PanovAlexey/geo-location) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Total Downloads](https://poser.pugx.org/codeblog.pro/geo-location/downloads)](https://packagist.org/packages/codeblog.pro/geo-location)
[![Version](https://poser.pugx.org/codeblog.pro/geo-location/version)](https://packagist.org/packages/codeblog.pro/geo-location)

The service allows you to get information about the current location by the IP address.

## Install

Via Composer

``` bash
$ composer require codeblog.pro/geo-location
```

## Usage

``` php
$currentIpResolver = new \CodeblogPro\GeoLocation\Application\Services\CurrentIpResolver;();
$geoLocationService = new \CodeblogPro\GeoLocation\Application\Services\GeoLocationService($currentIpResolver);
$geoLocationService->getCurrentIp();
$geoLocationService->getLocationByIp('8.8.8.8', 'RU');
$geoLocationService->getLocationArrayByIp('8.8.8.8', 'RU');
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email panov@codeblog.pro instead of using the issue tracker.

## Credits

- [Panov Alexey](https://www.linkedin.com/in/codeblog/)

## License

The Apache License License. Please see [License File](LICENSE) for more information.