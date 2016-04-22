<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Epoque\Chameleon;

/**
 * Description of SQLite3DB
 *
 * @author jason favrod <jason@epoquecorportation.com>
 */
class SQLite3DB
{
    private $conn;

    
    public static function select($query) {
        $conn = new \SQLite3(DATABASE);
        $queryResult = $conn->query($query);
        $result = [];
        
        while ($row = $queryResult->fetchArray(SQLITE3_ASSOC)) {
            foreach ($row as $attrib => $value) {
                $result[$attrib] = $value;
            }
        }
        
        $conn->close();
        return $result;
    }
    
    
    public static function update($query) {
        $conn = new \SQLite3(DATABASE);
        $queryResult = $conn->query($query)->numColumns();
        
        
        
        $conn->close();
        return $queryResult;        
    }
}
