<?php
/**
 * This file has many functionalitys to solve 
 * compatibility issues
 *
 *  PHP version 4
 *
 *  @category Utility
 *  @package  Utility
 *  @author   Edgard Leal <edgardleal@gmail.com>
 *  @version  GIT: 0.0.1
 *  @license  GNU
 */

/**
 * Provide compatibility with the versions 
 * after 5.4.0 
 */
if (!function_exists('http_response_code')) {

    /**
     * Define the http return code for current 
     * request
     *
     * @return The current code
     */
    function http_response_code($newcode = null)
    {
        static $code = 200;
        if ($newcode !== null) {
            header(
                'X-PHP-Response-Code: '
                . $newcode, true, $newcode
            );
            if (!headers_sent()) {
                $code = $newcode; 
            }
        }       
        return $code;
    }
}
