<?php
error_reporting(E_ALL);

require_once '../Password.php';


function timeToBruteForce ($password, $nbr = 0, $cmbPerSeconde = 4000) {
  global $_Text_Password_nbrCharacters;

  $nbr = ($nbr == 0) ? $_Text_Password_nbrCharacters : $nbr;
  $cmb = pow($nbr, strlen($password));
  $time_max = $cmb / $cmbPerSeconde;
  $time_min = ($cmb / $cmbPerSeconde) / 2;

  return array('combination' => $cmb,
               'max'         => $time_max,
               'min'         => $time_min);
}

echo "\nCreating pronounceable password of 10 chars....:\t";
echo Text_Password::create() . "\n\n";

echo "\nCreating 3 different pronounceable passwords...:\n";
print_r(Text_Password::createMultiple(3));

echo "\nCreating unpronounceable password of 8 chars with a,b,c as possible chars....:\t";
echo Text_Password::create(8, 'unpronounceable', 'a,b,c') . "\n\n";

echo "\nCreating 4 different unpronounceable passwords...:\n";
print_r(Text_Password::createMultiple(4, 10, 'unpronounceable'));

echo "\nEstimated time (in sec) to brute force an unpronounceable password of 5 chars with a 4000 combinations per second generator...:\n";
$pass = Text_Password::create(5, 'unpronounceable');
print_r(timeToBruteForce($pass));

echo "\nCreating unpronounceable password of 8 chars with numeric chars:\t";
echo Text_Password::create(8, 'unpronounceable', 'numeric') . "\n\n";

echo "\nCreating unpronounceable password of 8 chars with alphanumeric chars:\t";
echo Text_Password::create(8, 'unpronounceable', 'alphanumeric') . "\n\n";

echo "\nCreating password from login 'olivier', type is 'reverse':\t";
echo Text_Password::createFromLogin('olivier', 'reverse') . "\n\n";

echo "\nCreating password from login 'olivier', type is 'increment_char':\t";
echo Text_Password::createFromLogin('olivier', 'increment_char', 1) . "\n\n";

echo "\nCreating password from login 'olivier', type is 'increment_char2':\t";
echo Text_Password::createFromLogin('olivier', 'increment_char2', 1) . "\n\n";

echo "\nCreating password from login 'olivier', type is 'increment_char3':\t";
echo Text_Password::createFromLogin('olivier', 'increment_char3', 1) . "\n\n";

echo "\nCreating password from an array of login 'olivier', 'martin', 'vanhoucke', 'jansen', type is 'reverse':\n";
$logins = array('olivier', 'martin', 'vanhoucke', 'jansen');
print_r(Text_Password::createMultipleFromLogin($logins, 'reverse'));
?>
