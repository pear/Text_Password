<?php
error_reporting(E_ALL);

require_once '../Password.php';


function timeToBruteForce ($password, $nbr = 0, $cmbPerSeconde = 4000000) {
  global $_Text_Password_nbrCharacters;

  $nbr = ($nbr == 0) ? $_Text_Password_nbrCharacters : $nbr;
  $cmb = pow($nbr, strlen($password));
  $time_max = $cmb / $cmbPerSeconde;
  $time_min = ($cmb / $cmbPerSeconde) / 2;

  return array('combination' => $cmb,
               'max'         => $time_max,
               'min'         => $time_min);
}

echo '<pre>';

echo "\nCreating pronounceable password of 10 chars....:\t";
echo Text_Password::create() . "\n\n";

echo "\nCreating 3 different pronounceable passwords...:\n";
print_r(Text_Password::createMultiple(3));

echo "\nCreating unpronounceable password of 8 chars with a,b,c as possible chars....:\t";
echo Text_Password::create('unpronounceable', 8, 'a,b,c') . "\n\n";

echo "\nCreating 4 different unpronounceable passwords...:\n";
print_r(Text_Password::createMultiple(4, 'unpronounceable'));

echo "\nEstimated time (in sec) to brute force an unpronounceable password of 5 chars with a 4000000 combinations per second generator...:\n";
$pass = Text_Password::create('unpronounceable', 5);
print_r(timeToBruteForce($pass));



echo Text_Password::create('unpronounceable', 8, 'numeric') . "\n\n";
echo Text_Password::create('unpronounceable', 8, 'alphanumeric') . "\n\n";
echo Text_Password::create('unpronounceable', 8) . "\n\n";

echo Text_Password::createFromLogin('olivier', 'reverse') . "\n\n";
echo Text_Password::createFromLogin('olivier', 'increment_char', 1) . "\n\n";
echo Text_Password::createFromLogin('olivier', 'increment_char2', 1) . "\n\n";
echo Text_Password::createFromLogin('olivier', 'increment_char3', 1) . "\n\n";

echo '</pre>';
?>
