<?php
/**
 * Get all categories from the Random Joke database
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
    echo json_encode($db->getAllCategories());
} catch (exception $e) {
    http_response_code(503); // Service Unavailable
    echo '{}';
    exit($e->getMessage());
}
?>
