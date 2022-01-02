<?php 
/**
 * Database class for the jokemachine app
 * 
 * CREATE TABLE `jokes` (
 *   `id` int(11) NOT NULL AUTO_INCREMENT,
 *   `joke` text NOT NULL,
 *   `keywords` varchar(1000) DEFAULT NULL,
 *   `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
 *   `changed_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
 *   `deleted` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
 *   PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
     * Search the database for a specific string
     * 
     * @param string $str The search string
     * 
     * @return array|false
     */
    public function searchJokes($str) 
    {
        $query = 'SELECT * FROM jokes 
                  WHERE keywords LIKE :search_string  
                  OR joke LIKE :search_string 
                  WHERE deleted = 0;';
        $stmt = $this->prepare($query);
        $stmt->execute(['search_string' => "%{$str}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Select a random joke from the database
     * 
     * @param string $category_filter 
     * 
     * @return array|false
     */
    public function selectRandomJoke($category_filter=NULL) 
    {
        // TODO Filter by category
        $query = 'SELECT * FROM jokes WHERE deleted = 0 ORDER BY RAND() LIMIT 1;';
        $stmt = $this->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>