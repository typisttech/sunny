<?php

declare(strict_types=1);

// Here you can initialize variables that will be available to your tests.

use AspectMock\Kernel;

include codecept_root_dir('vendor/autoload.php'); // composer autoload.
$kernel = Kernel::getInstance();
$kernel->init(
    [
        'debug' => true,
        'includePaths' => [
            codecept_root_dir('lib/'),
            codecept_root_dir('src/'),
            codecept_root_dir('vendor/jamesryanbell/cloudflare/src/'),
        ],
    ]
);
