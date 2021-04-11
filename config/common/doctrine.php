<?php

use Doctrine\ORM\Tools\Setup;

return [
    'config' => Setup::createAnnotationMetadataConfiguration(
        [__DIR__."/../../src/Entity"],
        true,
        null,
        null,
        false
    ),
    'conn'  => [
        'driver' => 'pdo_sqlite',
        'path'   => __DIR__.'/../db/db.sqlite',
    ],
];
