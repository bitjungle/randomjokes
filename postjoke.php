<?php
/**
 * Post a joke to the Random Joke database
 * 
 * Copyright (C) 2022 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */
require_once 'Database.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    $db = new Database('settings-jokes-runeelev.ini');

     if (!isset($_POST['pwd']) || $db->validatePassword($_POST['pwd']) == 0) {
        echo '{"status": "wrong password"}';
        exit(0);
    }
   
    if (isset($_POST['joke']) && strlen($_POST['joke']) > 0) {
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $db->updateJoke(intval($_POST['id']), $_POST['joke']);
            echo '{"status": "updated joke"}';
        } else {
            $db->insertJoke($_POST['joke']);
            echo '{"status": "inserted joke"}';
        }
    } else if ((isset($_POST['delete']) && $_POST['delete'] == 'true') && 
               (isset($_POST['id']) && is_numeric($_POST['id']))) {
            $db->deleteJoke($_POST['id']);
            echo '{"status": "deleted joke"}';
    } else {
        echo '{"status": "did nothing"}';
    }

} catch (exception $e) {
    http_response_code(503); // Service Unavailable
    exit($e->getMessage());
}
?>
