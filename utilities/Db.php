<?php
/**
 * DB Connection
 *
 *  PHP version 4
 *
 *  @category Utility
 *  @package  Utility
 *  @author   Isaque Bressy <isaquebressy@gmail.com>
 *  @license  https://www.gnu.org/licenses/gpl.html GNU
 *  @version  GIT: 0.0.1
 */

class Db {
    private static $db;
    public static function init() {
        if (!self::$db) {
            try {
                $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8';
                self::$db = new PDO($dsn, DB_USER, DB_PASS);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Connnection Error: '.$e->getMessage());
            }
        }
        return self::$db;
    }
}

