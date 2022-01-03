<?php 
/**
 * Database class for the Random Joke app
 * 
 * Copyright (C) 2022 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 *
 * @author  BITJUNGLE Rune Mathisen <devel@bitjungle.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU GPLv3
 */
class Database extends PDO 
{
    private $_ini;

    /**
     * Create a new DB object
     * 
     * @param string $file INI file name.
     */
    public function __construct($file = '/path/to/settings.ini') 
    {
        $this->_ini = parse_ini_file($file, true);

        $dsn = $this->_ini['db']['driver'] . 
        ':dbname=' . $this->_ini['db']['dbname'] .
        ';host=' . $this->_ini['db']['host'];
        
        parent::__construct(
            $dsn, 
            $this->_ini['db']['user'], 
            $this->_ini['db']['passwd']
        );
    }

    /**
     * Select all data in the database table
     * 
     * @return array|false
     */
    public function getAllJokes() 
    {
        $query = 'SELECT * FROM jokes WHERE deleted = 0;';
        $stmt = $this->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Select a random joke from the database
     * 
     * @param string $category
     * @return array|false
     */
    public function selectRandomJoke($category=NULL) 
    {
        if ($category) {
            $cat_id = $this->getCategoryId($category);
            $query = "SELECT * FROM jokes 
                      WHERE id IN (
                        SELECT joke_id 
                        FROM jokes_categories 
                        WHERE categories_id = {$cat_id})
                      AND deleted = 0 
                      ORDER BY RAND() LIMIT 1;";
        } else {
            $query = 'SELECT * FROM jokes 
            WHERE deleted = 0 
            ORDER BY RAND() LIMIT 1;';
        }
        $stmt = $this->prepare($query);
        $stmt->execute();
        $assoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log(json_encode($assoc), 0);
        return $assoc;
    }

    /**
     * Search the database for a specific string
     * 
     * @param string $str The search string
     * @return array|false
     */
    public function searchJokes($str) 
    {
        $query = 'SELECT * FROM jokes 
                  WHERE value LIKE :search_string  
                  AND deleted = 0;';
        $stmt = $this->prepare($query);
        $stmt->execute(['search_string' => "%{$str}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return all joke categories as a list
     * 
     * @return array
     */
    public function getAllCategories() 
    {
        $query = 'SELECT value FROM categories;';
        $stmt = $this->prepare($query);
        $stmt->execute();
        $assoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        foreach ($assoc as $val) {
            array_push($list, $val['value']);
        }
        return $list;
    }

    /**
     * Get category id for the specified category value
     * 
     * @param string $category
     * @return int
     */
    private function getCategoryId($category) {
        $query = 'SELECT id FROM categories WHERE value = :search_string;';
        $stmt = $this->prepare($query);
        $stmt->execute(['search_string' => $category]);
        $assoc = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return intval($assoc[0]['id']);
    }
}
?>