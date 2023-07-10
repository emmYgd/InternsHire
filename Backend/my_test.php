<?php
//generate purely random numbers:
		$strBase = "0123456789@#$%^&*";
		$strShuffle1 = str_shuffle($strBase);
		$strShuffle2 = str_shuffle($strBase);

		$strCombine = $strShuffle1 . $strShuffle2;

		$uniqueID = str_shuffle(substr( $strCombine, 0, 15));
		echo $uniqueID;
?>