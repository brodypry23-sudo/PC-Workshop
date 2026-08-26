<?php

session_start();

$_SESSION['userId'] = 42;
$_SESSION['userName'] = 'brody';

if ( isset( $_SESSION['TEST'])) {
    echo $_SESSION['TEST'];
} else {
    echo 'test is not set';
    $_SESSION['TEST'] = 'its a lovly day';
}

$TEST = $_SESSION['TEST'];


unset($_SESSION['TEST']);

session_destroy();

?>
