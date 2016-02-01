<?php
// +------------------------------------------------------------------------+
// | PEAR :: Text_Password                                                  |
// +------------------------------------------------------------------------+
// | Copyright (c) 2004 Martin Jansen                                       |
// +------------------------------------------------------------------------+
// | This source file is subject to version 3.00 of the PHP License,        |
// | that is available at http://www.php.net/license/3_0.txt.               |
// | If you did not receive a copy of the PHP license and are unable to     |
// | obtain it through the world-wide-web, please send a note to            |
// | license@php.net so we can mail you a copy immediately.                 |
// +------------------------------------------------------------------------+
//
// $Id$
//

require_once "Text/Password.php";

/**
 * Unit test suite for the Text_Password package
 *
 * @author  Martin Jansen <mj@php.net>
 * @extends PHPUnit_TestCase
 * @version $Id$
 */
class Text_Password_Test extends PHPUnit_Framework_TestCase {

    function setUp() {
        $this->subject = new Text_Password();
    }
    function testCreate()
    {
        $password = $this->subject->create();
        $this->assertTrue(strlen($password) == 10);
    }

    function testCreateWithLength()
    {
        $password = $this->subject->create(15);
        $this->assertTrue(strlen($password) == 15);
    }

    function testCreateMultiple()
    {
        $passwords = $this->subject->createMultiple(3);
        $this->_testCreateMultiple($passwords, 3, 10);
    }

    function testCreateMultipleWithLength()
    {
        $passwords = $this->subject->createMultiple(3, 15);
        $this->_testCreateMultiple($passwords, 3, 15);
    }

    function testCreateNumericWithLength()
    {
        $password = $this->subject->create(8, 'unpronounceable', 'numeric');

        $this->assertRegExp("/^[0-9]{8}$/", $password);
    }

    function testCreateFromABCWithLength()
    {
        $password = $this->subject->create(8, 'unpronounceable', 'a,b,c');
        $this->assertRegExp("/^[abc]{8}$/i", $password);
    }

    function testCreateAlphabeticWithLength()
    {
        $password = $this->subject->create(8, 'unpronounceable', 'alphabetic');

        $this->assertRegExp("/^[a-z]{8}$/i", $password);
    }

    function testCreateUnpronouncableWithAllClasses()
    {
        $password = $this->subject->create(8, 'unpronounceable', '');
        $this->assertRegExp('/^[a-z0-9_#@%&]{8}$/i', $password);

        // Make sure all character classes are used at least once.
        $this->assertRegExp('/[a-z]/', $password);
        $this->assertRegExp('/[A-Z]/', $password);
        $this->assertRegExp('/[0-9]/', $password);
        $this->assertRegExp('/[_#@%&]/', $password);
    }

    /**
     * Ensures short password generation, where the length is less than the
     * number of character classes, works properly
     */
    function testCreateUnpronouncableShortWithAllClasses()
    {
        $password = $this->subject->create(2, 'unpronounceable', '');
        $this->assertRegExp('/^[a-z0-9_#@%&]{2}$/i', $password);
    }

    // {{{ Test cases for creating passwords based on a given login string

    function testCreateFromLoginReverse()
    {
        $this->assertEquals("eoj", $this->subject->createFromLogin("joe", "reverse"));
    }

    function testCreateFromLoginShuffle()
    {
        $this->assertTrue(strlen($this->subject->createFromLogin("hello world", "shuffle")) == strlen("hello world"));
    }

    function testCreateFromLoginRotX()
    {
        $this->assertEquals("tyo", $this->subject->createFromLogin("joe", "rotx", 10));
    }
    
    function testCreateFromLoginRot13()
    {
        $this->assertEquals("wbr", $this->subject->createFromLogin("joe", "rot13"));
    }

    function testCreateFromLoginRotXplusplus()
    {
        $this->assertEquals("syp", $this->subject->createFromLogin("joe", "rotx++", 9));
    }

    function testCreateFromLoginRotXminusminus()
    {
        $this->assertEquals("swl", $this->subject->createFromLogin("joe", "rotx--", 9));
    }

    function testCreateFromLoginXOR()
    {
        $this->assertEquals("oj`", $this->subject->createFromLogin("joe", "xor", 5));
    }

    function testCreateFromLoginASCIIRotX()
    {
        $this->assertEquals("otj", $this->subject->createFromLogin("joe", "ascii_rotx", 5));
    }

    function testCreateFromLoginASCIIRotXplusplus()
    {
        $this->assertEquals("oul", $this->subject->createFromLogin("joe", "ascii_rotx++", 5));
    }

    function testCreateFromLoginASCIIRotXminusminus()
    {
        $this->assertEquals("uyn", $this->subject->createFromLogin("joe", "ascii_rotx--", 11));
    }

    /**
     * Unit test for bug #2605
     *
     * Actually this method does not implement a real unit test, but 
     * instead it is there to make sure that no warning is produced
     * by PHP.
     *
     * @link http://pear.php.net/bugs/bug.php?id=2605
     */
    function testBugReport2605()
    {
        $password = $this->subject->create(7, 'unpronounceable', '1,3,a,Q,~,[,f');
        $this->assertTrue(strlen($password) == 7);
    }

    // }}}
    // {{{ private helper methods

    function _testCreateMultiple($passwords, $count, $length)
    {
        $this->assertInternalType("array", $passwords);
        $this->assertTrue(count($passwords) == $count);

        foreach ($passwords as $password) {
            $this->assertTrue(strlen($password) == $length);
        }        
    }

    // }}}
}
