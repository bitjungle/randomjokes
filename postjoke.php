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

try {
    $db = new Database('settings-jokes-runeelev.ini');
    error_log("Got this joke: {$_POST['joke']}");
    error_log("Got this id: {$_POST['id']}");
    error_log("Got this password: {$_POST['pwd']}");

     if (!isset($_POST['pwd']) || $db->validatePassword($_POST['pwd']) == 0) {
        exit(0);
    } else {
        echo $_POST['pwd'];
    }
   
    if (isset($_POST['joke']) && strlen($_POST['joke']) > 0) {
        error_log("Got a joke");
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            echo 'updating';
            $db->updateJoke(intval($_POST['id']), $_POST['joke']);
        } else {
            error_log('Inserting a joke');
            echo 'inserting';
            $db->insertJoke($_POST['joke']);
        }
    } else if ((isset($_POST['delete']) && $_POST['delete'] == 'true') && 
               (isset($_POST['id']) && is_numeric($_POST['id']))) {
            echo 'deleting';
            $db->deleteJoke($_POST['id']);
    } else {
        echo 'nothing';
    }

} catch (exception $e) {
    http_response_code(503); // Service Unavailable
    exit($e->getMessage());
}
?>
