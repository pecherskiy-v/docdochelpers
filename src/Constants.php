<?php

namespace Pecherskiy\DocDoc;

class Constants
{
    private const SERVER_URL
        = [
            'test'            => 'https://api.bookingtest.docdoc.pro',
            'production'      => 'https://api.docdoc.ru/public/rest/1.0.12',
            'mock_server'     => 'https://private-anon-36d6945e55-dd1012.apiary-mock.com/public/rest/1.0.12',
            'debugging_proxy' => 'https://private-anon-36d6945e55-dd1012.apiary-proxy.com/public/rest/1.0.12',
        ];

    public static function getServerUrl(string $type) : string
    {
        if ('test' === $type) {
            return self::SERVER_URL['test'];
        }

        if ('mock_server' === $type) {
            return self::SERVER_URL['mock_server'];
        }

        if ('debugging_proxy' === $type) {
            return self::SERVER_URL['debugging_proxy'];
        }

        return self::SERVER_URL['production'];
    }
}
