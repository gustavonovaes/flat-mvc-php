<?php

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../src/config.php';

require __DIR__. '/../src/error_handler.php';

$route = require __DIR__ . '/../src/routes.php';

$route->dispatch();