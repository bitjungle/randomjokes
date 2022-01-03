<?php
/**
 * Get a joke from the Random Joke from the database
 * 
 * Copyright (C) 2022 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */
require_once 'Database.php';
try {
    $db = new Database('/path/to/settings.ini');
    if (isset($_POST['category']) && strlen($_POST['category']) > 0) {
        echo json_encode($db->selectRandomJoke($_POST['category']));
    } else if (isset($_GET['category']) && strlen($_GET['category']) > 0) {
        echo '<!DOCTYPE html>
              <html>
              <head><meta charset="UTF-8"><title>search</title></head>
              <body><data id="response" style="font-family: monospace">';
        echo json_encode($db->selectRandomJoke($_GET['category']));
        echo '</data></body></html>';
    } else {
        echo json_encode($db->selectRandomJoke()[0]);
    }
} catch (exception $e) {
    http_response_code(503); // Service Unavailable
    echo '{}';
    exit($e->getMessage());
}
?>
