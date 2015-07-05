<?php

include 'session.class.php';

$session_start = new initiate_session();
$logout_stop = new stop_session();

header("Location: ../login.page.php");	
