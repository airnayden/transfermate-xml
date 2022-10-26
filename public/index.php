<?php

/**
 * @var \App\Application $app
 */
$app = require_once '../bootstrap/app.php';
$app->executeWebAction($_GET['action'] ?? env('DEFAULT_ACTION'));

exit();