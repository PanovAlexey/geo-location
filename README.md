# Geo location service package

[![Build Status](https://travis-ci.org/PanovAlexey/geo-location.svg?branch=master)](https://travis-ci.org/PanovAlexey/geo-location) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/PanovAlexey/geo-location/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Total Downloads](https://poser.pugx.org/codeblog.pro/geo-location/downloads)](https://packagist.org/packages/codeblog.pro/geo-location)
[![Version](https://poser.pugx.org/codeblog.pro/geo-location/version)](https://packagist.org/packages/codeblog.pro/geo-location)

The package is a wrapper for several geolocation services at once. 
The main task of the package is to determine the user's location by IP. 
Due to the possibility of using several providers at once,
 the free limit of each provider is summed up.


## Install

Via Composer

``` bash
$ composer require codeblog.pro/geo-location
```

## Usage

``` php
$geoLocationService = new \CodeblogPro\GeoLocation\Application\Services\GeoLocationService();
$location = $geoLocationService->getLocationByIpAndLanguageResultCode('8.8.8.8', 'EN');
var_dump($location);

$locationArray = $geoLocationService->getLocationArrayByIpAndLanguageResultCode('8.8.8.8', 'RU');
var_dump($locationArray);

$currentIpResolver = new \CodeblogPro\GeoLocation\Application\Services\CurrentIpResolver();
$currentIp = $geoLocationService->getCurrentIpByIpResolver($currentIpResolver)->getValue();
var_dump($currentIp);

$locationByIpResolverAndLanguageResultCode = $geoLocationService->getLocationByIpResolverAndLanguageResultCode(
    $currentIpResolver,
    'RU'
);
var_dump($locationByIpResolverAndLanguageResultCode);
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
