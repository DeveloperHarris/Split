<?php

function generateTransactionId(){
	$stringLen = 30;
	$returnString = "";
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charLen = strlen($characters);
	for ($i = 0; $i < $stringLen; $i++)
	{
		$returnString .= $characters[rand(0, $charLen - 1)];
	}
	return $returnString;
}
?>