<?php

$env = $_SERVER['APP_ENV'] ?? 'local';

switch($env) {
    case 'production':
        return require __DIR__ . '/config.prod.php';
    case 'staging':
        return require __DIR__ . '/config.staging.php';
    default:
        return require __DIR__ . '/config.local.php';
}