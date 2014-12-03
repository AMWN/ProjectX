<?php

if (isset($_POST['data'][0])) {
    $action = $_POST['data'][0];
}

if (isset($_POST['data'][1])) {
    $connector = $_POST['data'][1];
}

error_reporting(-1);
ini_set('display_errors', 'On');
require_once(__DIR__.'/includes/class.test.php');

$test = new connector($action, $connector, '', '');
$arr = array (
  'data' => $test->result['data'],
  'columns' => $test->result['columns']
);

print json_encode($arr);

?>