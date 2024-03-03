<?php

require_once 'php_action/core.php';

// remove all session variables
session_unset();

// destroy the session 
session_destroy();

header('location: http://128.199.248.115/grocery/stock/index.php');
