<?php
/**
 * Post a joke to the Random Joke database
 * 
 * Copyright (C) 2022 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */
require_once 'Database.php';

//header('Access-Control-Allow-Origin: *');

try {
    $db = new Database('settings.ini');

    if (!isset($_GET['pwd']) || $db->validatePassword($_GET['pwd']) == 0) {
        exit(0);
    }
    
    if (isset($_GET['joke']) && strlen($_GET['joke']) > 0) {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            echo 'updating';
            $db->updateJoke(intval($_GET['id']), $_GET['joke']);
        } else {
            echo 'inserting';
            $db->insertJoke($_GET['joke']);
        }
    } else if ((isset($_GET['delete']) && $_GET['delete'] == 'true') && 
               (isset($_GET['id']) && is_numeric($_GET['id']))) {
            echo 'deleting';
            $db->deleteJoke($_GET['id']);
    } else {
        echo 'nothing';
    }

} catch (exception $e) {
    http_response_code(503); // Service Unavailable
    exit($e->getMessage());
}
?>
