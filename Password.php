<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Martin Jansen <mj@php.net>                                  |
// +----------------------------------------------------------------------+
//
// $Id$
//

/**
 * Create passwords
 *
 * @package Text_Password
 * @author  Martin Jansen
 */
class Text_Password {

    /**
     * Create a single password.
     *
     * @access public
     * @param  string  Type of password (pronounceable etc.)
     * @param  integer Length of the password.
     * @return string
     */
    function create($type = "pronounceable", $length = 10) {
        srand();

        switch ($type) {
        case "pronounceable" :
        default :
            return Text_Password::_createPronounceable($length);            
        }
    }

    /**
     * Create multiple, different passwords
     *
     * Method to create a list of different passwords which are
     * all different.
     *
     * @access public
     * @param  integer Length of the password
     * @param  integer Number of different password
     * @return array   Array containing the passwords
     */
    function createMultiple($number, $type = "pronounceable", $length = 10)
    {
        $passwords = array();

        while ($number > 0) {
            while (true) {
                $password = Text_Password::create($type, $length);
                if (!in_array($password, $passwords)) {
                    $passwords[] = $password;
                    break;
                }
            }
            $number--;
        }
        return $passwords;
    }

    /**
     * Create pronounceable password
     *
     * This method creates a string that consists of
     * vowels and consonats.
     *
     * @access private
     * @param  integer Length of the password
     * @return string  Returns the password
     */
    function _createPronounceable($length)
    {
        $retVal = "";

        /**
         * List of vowels and vowel sounds
         */
        $v = array('a', 'e', 'i', 'o', 'u', 'ae', 'ou', 'io', 
                   'ea', 'ou', 'ia', 'ai'
                   ); 

        /**
         * List of consonants and consonant sounds
         */
        $c = array('b', 'c', 'd', 'g', 'h', 'j', 'k', 'l', 'm',
                   'n', 'p', 'r', 's', 't', 'u', 'v', 'w', 
                   'tr', 'cr', 'fr', 'dr', 'wr', 'pr', 'th',
                   'ch', 'ph', 'st', 'sl', 'cl'
                   );

        /**
         * XXX: Make this static!
         */
        $v_count = count($v);
        $c_count = count($c);

        for ($i = 0; $i < $length; $i++) {
            $retVal .= $c[rand(0, $c_count-1)] . $v[rand(0, $v_count-1)];
        }
    
        return substr($retVal, 0, $length);
    }
}
?>
