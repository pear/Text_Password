<?php
error_reporting(E_ALL);

require_once "../Password.php";

echo "\nCreating password of 10 chars....:\t";
echo Text_Password::create() . "\n\n";

echo "\nCreating 3 different passwords...:\n";
print_r(Text_Password::createMultiple(3));
?>
