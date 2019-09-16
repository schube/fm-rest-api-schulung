<?php
require 'config.php';

use Schubec\PHPHelpers\Session as Session;
Session::reset();
header("Location: index.php");
	
