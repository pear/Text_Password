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
// |          Olivier Vanhoucke <olivier@php.net>                         |
// +----------------------------------------------------------------------+
//
// $Id$
//

$_Text_Password_nbrCharacters = 0;

/**
 * Create passwords
 *
 * @package Text_Password
 * @author  Martin Jansen <mj@php.net>
 * @author  Olivier Vanhoucke <olivier@php.net>
 */
class Text_Password {

    /**
     * Create a single password.
     *
     * @access public
     * @param  integer Length of the password.
     * @param  string  Type of password (pronounceable, unpronounceable etc.)
     * @param  string  Character which could be use in the unpronounceable password ex : 'A,B,C,D,E,F,G' or numeric or alphanumeric
     * @return string
     */
    function create($length = 10, $type = 'pronounceable', $chars = '') {

        mt_srand((double) microtime() * 1000000);

        switch ($type) {
        case 'unpronounceable' :
            return Text_Password::_createUnpronounceable($length, $chars);

        case 'pronounceable'   :
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
     * @param  integer Number of different password
     * @param  integer Length of the password
     * @param  string  Type of password (pronounceable, unpronounceable etc.)
     * @param  string  Character which could be use in the unpronounceable password ex : 'A,B,C,D,E,F,G' or numeric or alphanumeric
     * @return array   Array containing the passwords
     */
    function createMultiple($number, $length = 10, $type = 'pronounceable', $chars = '') {

        $passwords = array();

        while ($number > 0) {
            while (true) {
                $password = Text_Password::create($length, $type, $chars);
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
     * Create password from login
     *
     * Method to create password from login
     *
     * @access public
     * @param  string  Login
     * @param  string  Type
     * @param  integer ?
     * @return string
     */
    function createFromLogin($login, $type, $cpt = 0) {

        switch ($type) {
        case 'reverse':
            return Text_Password::_reverseLogin($login);

        case 'increment_char':
            return Text_Password::_incrementLoginChar($login, $cpt);

        case 'increment_char2':
            return Text_Password::_incrementLoginChar2($login, $cpt);

        case 'increment_char3':
            return Text_Password::_incrementLoginChar3($login, $cpt);
        }
    }

    /**
     * Create multiple, different passwords from an array of login
     *
     * Method to create a list of different password from login
     *
     * @access public
     * @param  array   Login
     * @param  string  Type
     * @param  integer ?
     * @return array   Array containing the passwords
     */
    function createMultipleFromLogin($login, $type, $cpt = 0) {

        $passwords = array();
        $number    = count($login);
        $save      = $number;

        while ($number > 0) {
            while (true) {
                $password = Text_Password::createFromLogin($login[$save - $number], $type, $cpt);
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
     * Create password from login
     *
     * Method to create a password which is the reverse of the login
     *
     * @access private
     * @param  string  Login
     * @return string
     */
    function _reverseLogin($login) {

        for ($i=0; $i < strlen($login); $i++) {
            $tmp[] = $login{$i};
        }

        return implode(array_reverse($tmp), '');
    }

    /**
     * Create password from login
     *
     * Method to create a password from a login
     *
     * @access private
     * @param  string  Login
     * @return string
     */
    function _incrementLoginChar($login, $cpt) {

        for ($i=0; $i < strlen($login); $i++) {
            $tmp[] = chr(ord($login{$i}) + $cpt);
        }

        return implode($tmp, '');
    }

    /**
     * Create password from login
     *
     * Method to create a password from a login
     *
     * @access private
     * @param  string  Login
     * @return string
     */
    function _incrementLoginChar2($login, $cpt) {

        for ($i=0; $i < strlen($login); $i++) {
            $tmp[] = chr(ord($login{$i}) + $cpt);
            $cpt++;
        }

        return implode($tmp, '');
    }

    /**
     * Create password from login
     *
     * Method to create a password from a login
     *
     * @access private
     * @param  string  Login
     * @return string
     */
    function _incrementLoginChar3($login, $cpt) {

        for ($i=0; $i < strlen($login); $i++) {
            $tmp[] = $login{$i};
        }

        shuffle($tmp);

        return implode($tmp, '');
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
    function _createPronounceable($length) {

        global $_Text_Password_nbrCharacters;

        $retVal = '';

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

        $_Text_Password_nbrCharacters = $v_count + $c_count;

        for ($i = 0; $i < $length; $i++) {
            $retVal .= $c[mt_rand(0, $c_count-1)] . $v[mt_rand(0, $v_count-1)];
        }

        return substr($retVal, 0, $length);
    }

    /**
     * Create unpronounceable password
     *
     * This method creates a random unpronounceable password
     *
     * @access private
     * @param  integer Length of the password
     * @param  string  Character which could be use in the password ex : 'A,B,C,D,E,F,G' or numeric or alphanumeric
     * @return string  Returns the password
     */
    function _createUnpronounceable($length, $chars) {  // en cours

        global $_Text_Password_nbrCharacters;

        $password = '';

        /**
         * List of character which could be use in the password
         */
         switch($chars) {

         case 'alphanumeric':
             $regex = 'A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|0|1|2|3|4|5|6|7|8|9';
             $_Text_Password_nbrCharacters = 62;
             break;

         case 'numeric':
             $regex = '0|1|2|3|4|5|6|7|8|9';
             $_Text_Password_nbrCharacters = 10;
             break;

         case '':
             $regex = '_|#|@|%|£|&|ç|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|0|1|2|3|4|5|6|7|8|9';
             $_Text_Password_nbrCharacters = 69;
             break;

         default:
             /**
              * Some characters couldn't be used
              */
             $chars = trim($chars);
             $chars = str_replace('+' , '' , $chars);
             $chars = str_replace('|' , '' , $chars);
             $chars = str_replace('$' , '' , $chars);
             $chars = str_replace('^' , '' , $chars);
             $chars = str_replace('/' , '' , $chars);
             $chars = str_replace('\\', '' , $chars);
             $chars = str_replace(',,', ',', $chars);

             if ($chars{strlen($chars)-1} == ',') {
                 $chars = substr($chars, 0, -1);
             }

             $regex = str_replace(',', '|', $chars);
             $_Text_Password_nbrCharacters = strlen(str_replace(',', '', $chars));
         }

         /**
          * Generate password
          */

         do {
             $chr = chr(mt_rand(0, 255));
             if (preg_match('/'.$regex.'/US', $chr)) {
                 $password .= $chr;
             }
         } while (strlen($password) < $length);

         /**
          * Return password
          */
         return $password;
    }
}
?>
