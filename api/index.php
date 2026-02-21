<?php

// Vercel serverless environment is read-only except for /tmp.
// We redirect Laravel compiled views and cache directories to /tmp.
$storageViews = '/tmp/storage/framework/views';
if (!is_dir($storageViews)) {
    mkdir($storageViews, 0777, true);
}

$storageSession = '/tmp/storage/framework/sessions';
if (!is_dir($storageSession)) {
    mkdir($storageSession, 0777, true);
}

$_ENV['VIEW_COMPILED_PATH'] = $storageViews;
$_SERVER['VIEW_COMPILED_PATH'] = $storageViews;

// Forward Vercel requests to standard Laravel index.php
require __DIR__ . '/../public/index.php';
