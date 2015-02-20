<?php

use MyApp\Application;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application();

echo $app->config->get('app.first_name') . ' ' . $app->config->get('app.family_name');