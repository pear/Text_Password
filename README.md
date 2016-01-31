Text_Password
=============
Class that provides various types of password generation.

Usage
-----
Generating passwords is a very common task in web applications. This package
provides an easy-to-use and intuitive API to generate:

 * pronounceable passwords
 * unpronounceable passwords
 * passwords based on a given string

For the last point, multiple, simple *obfuscation* algorithms are supported.

### Creating a Pronouncable Password
```php
<?php

require_once 'Text/Password.php';

// Create pronouncable password of 10 characters.
echo Text_Password::create() . "\n";

// Create 3 different pronouncable passwords of length 8.
print_r(Text_Password::createMultiple(3, 8));

?>
```

### Creating an Unpronouncable Password
```php
<?php

require_once 'Text/Password.php';

// Create unpronounceable password of length 8 with a, b, and c as
// possible characters.
echo Text_Password::create(8, 'unpronounceable', 'abc') . "\n";

// Create 4 different unpronounceable passwords of length 10.
print_r(Text_Password::createMultiple(4, 10, 'unpronounceable'));

// Creating unpronounceable password of 8 chars with only alphanumeric
// characters. Other classes that can be specified are 'numeric', 'alphabetic'
// and '' for all characters.
echo Text_Password::create(8, 'unpronounceable', 'alphanumeric') . "\n";

?>
```

### Creating passwords based on a given string:
```php
<?php

require_once 'Text/Password.php';

// Create password from login 'olivier', type is 'reverse'. Other supported
// types are:
//
// - 'rot13'
// - 'rotx'
// - 'rotx++',
// - 'rotx--',
// - 'xor',
// - 'ascii_rotx',
// - 'ascii_rotx++',
// - 'ascii_rotx--',
// - 'shuffle',
echo Text_Password::createFromLogin('olivier', 'reverse') . "\n";

// Create multiple passwords from array of logins.
$logins = array('olivier', 'martin', 'vanhoucke', 'jansen');
print_r(Text_Password::createMultipleFromLogin($logins, 'reverse'));

?>
```

Installation
------------

### PEAR
```sh
pear install Text_Password
```

### Composer
```
./composer.phar require pear/text_password
```

Links
-----
 * [Homepage](http://pear.php.net/package/Text_Password)
 * [Documentation](http://pear.php.net/manual/en/package.text.text-password.php)
 * [Source code](https://github.com/pear/Text_Password)
 * [Issue tracker](http://pear.php.net/bugs/search.php?cmd=display&package_name[]=Text_Password)
 * [Unit test status](https://travis-ci.org/pear/Text_Password)
 * [Packagist](https://packagist.org/packages/pear/text_password)
