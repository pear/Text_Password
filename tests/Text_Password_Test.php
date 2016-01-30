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

require_once 'Text/Password.php';

/**
 * Unit test suite for the Text_Password package
 *
 * @author  Martin Jansen <mj@php.net>
 * @extends PHPUnit_TestCase
 * @version $Id$
 */
class Text_Password_Test extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $password = Text_Password::create();
        $this->assertTrue(strlen($password) == 10);
    }

    public function testCreateWithLength()
    {
        $password = Text_Password::create(15);
        $this->assertTrue(strlen($password) == 15);
    }

    public function testCreateMultiple()
    {
        $passwords = Text_Password::createMultiple(3);
        $this->_testCreateMultiple($passwords, 3, 10);
    }

    public function testCreateMultipleWithLength()
    {
        $passwords = Text_Password::createMultiple(3, 15);
        $this->_testCreateMultiple($passwords, 3, 15);
    }

    public function testCreateNumericWithLength()
    {
        $password = Text_Password::create(8, 'unpronounceable', 'numeric');

        $this->assertRegExp("/^[0-9]{8}$/", $password);
    }

    public function testCreateFromABCWithLength()
    {
        $password = Text_Password::create(8, 'unpronounceable', 'a,b,c');
        $this->assertRegExp("/^[abc]{8}$/i", $password);
    }

    public function testCreateAlphabeticWithLength()
    {
        $password = Text_Password::create(8, 'unpronounceable', 'alphabetic');

        $this->assertRegExp("/^[a-z]{8}$/i", $password);
    }

    public function testCreateUnpronouncableWithAllClasses()
    {
        $password = Text_Password::create(8, 'unpronounceable', '');
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
    public function testCreateUnpronouncableShortWithAllClasses()
    {
        $password = Text_Password::create(2, 'unpronounceable', '');
        $this->assertRegExp('/^[a-z0-9_#@%&]{2}$/i', $password);
    }

    // {{{ Test cases for creating passwords based on a given login string

    public function testCreateFromLoginReverse()
    {
        $this->assertEquals("eoj", Text_Password::createFromLogin("joe", "reverse"));
    }

    public function testCreateFromLoginShuffle()
    {
        $this->assertTrue(strlen(Text_Password::createFromLogin("hello world", "shuffle")) == strlen("hello world"));
    }

    public function testCreateFromLoginRotX()
    {
        $this->assertEquals("tyo", Text_Password::createFromLogin("joe", "rotx", 10));
    }

    public function testCreateFromLoginRot13()
    {
        $this->assertEquals("wbr", Text_Password::createFromLogin("joe", "rot13"));
    }

    public function testCreateFromLoginRotXplusplus()
    {
        $this->assertEquals("syp", Text_Password::createFromLogin("joe", "rotx++", 9));
    }

    public function testCreateFromLoginRotXminusminus()
    {
        $this->assertEquals("swl", Text_Password::createFromLogin("joe", "rotx--", 9));
    }

    public function testCreateFromLoginXOR()
    {
        $this->assertEquals("oj`", Text_Password::createFromLogin("joe", "xor", 5));
    }

    public function testCreateFromLoginASCIIRotX()
    {
        $this->assertEquals("otj", Text_Password::createFromLogin("joe", "ascii_rotx", 5));
    }

    public function testCreateFromLoginASCIIRotXplusplus()
    {
        $this->assertEquals("oul", Text_Password::createFromLogin("joe", "ascii_rotx++", 5));
    }

    public function testCreateFromLoginASCIIRotXminusminus()
    {
        $this->assertEquals("uyn", Text_Password::createFromLogin("joe", "ascii_rotx--", 11));
    }

    // }}}

    /**
     * Unit test for bug #2605
     *
     * Actually this method does not implement a real unit test, but
     * instead it is there to make sure that no warning is produced
     * by PHP.
     *
     * @link http://pear.php.net/bugs/bug.php?id=2605
     */
    public function testBugReport2605()
    {
        $password = Text_Password::create(7, 'unpronounceable', '1,3,a,Q,~,[,f');
        $this->assertTrue(strlen($password) == 7);
    }

    // {{{ private helper methods

    protected function _testCreateMultiple($passwords, $count, $length)
    {
        $this->assertInternalType("array", $passwords);
        $this->assertTrue(count($passwords) == $count);

        foreach ($passwords as $password) {
            $this->assertTrue(strlen($password) == $length);
        }
    }

    // }}}
}
