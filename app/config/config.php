<?php
return [
    'vkServiceKey' => getenv('VK_SERVICE_KEY'),
    'connection' => [
        'host' => getenv('MYSQL_HOST'),
        'password' => getenv('MYSQL_PASSWORD'),
        'db' => getenv('MYSQL_DATABASE'),
        'port' => getenv('MYSQL_PORT'),
        'user' => getenv('MYSQL_USERNAME')
    ]
];