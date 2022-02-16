<?php
/**
 * Get a joke from the Random Joke from the database
 * 
 * Copyright (C) 2022 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */
require_once 'Database.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    $db = new Database('settings.ini');
    error_log('id=' . $_GET['id'], 0);
    if (isset($_GET['id']) && strlen($_GET['id']) > 0) {
        echo json_encode($db->selectJoke(intval($_GET['id']))[0]);
    } else {
        echo '{}';
    }
} catch (exception $e) {
    http_response_code(503); // Service Unavailable
    echo '{}';
    exit($e->getMessage());
}
?>
