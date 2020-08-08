<?php
return [
    'dadata' => [
        'enabled' => env('DADATA_ENABLED'),
        'sort' => env('DADATA_SORT'),
        'key' => env('DADATA_KEY'),
        'url' => env('DADATA_GEO_LOCATION_URL'),
    ],
    'sypex' => [
        'enabled' => env('SYPEX_ENABLED'),
        'sort' => env('SYPEX_SORT'),
        'key' => env('SYPEX_KEY'),
        'url' => env('SYPEX_GEO_LOCATION_URL'),
    ],
    'maxmind' => [
        'enabled' => env('MAXMIND_ENABLED'),
        'sort' => env('MAXMIND_SORT'),
        'key' => env('MAXMIND_KEY'),
        'url' => env('MAXMIND_GEO_LOCATION_URL'),
    ],
];