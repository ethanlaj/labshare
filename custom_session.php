<?php
// error reporting all
// error_reporting(E_ALL);
// ini_set('display_errors', 'on');

require_once 'vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreSessionHandler;

// Check if the application is running on Google Cloud App Engine
if (getenv('GAE_APPLICATION')) {
    // Initialize Datastore client
    $datastore = new DatastoreClient([
        'projectId' => 'labshare-370015',
    ]);

    // Configure the session handler
    $handler = new DatastoreSessionHandler($datastore);

    // Register the session handler
    session_set_save_handler($handler, true);
}

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
