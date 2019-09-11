<?php
session_start();



function isUserLoggedIn() {
	if(array_key_exists('angemeldet', $_SESSION) && $_SESSION['angemeldet']==true) {
		return true;
	} else {
		return false;
	}
}


?>