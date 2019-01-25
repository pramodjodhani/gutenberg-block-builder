<?php 

function stg_trim_fn($fn) {

	if(strpos($fn, "()") != -1) {
		$fn = str_replace("()","" , $fn);
	}

	return $fn;

}