<?php

class SEARCH_ENGINE
{
	public $param;
	protected $query;

	public function multi_param_search($param)
	{
		$query = " SELECT something FROM `table` 
		WHERE 1 = 1
		"; // define first query statement and initial with 1=1 anywhere query.

		if ($param !== "") { // check for input parameters

			//** version 1. */
			// Check if the input has space in it
			// If yes, split the input by space and assign it to an array of keywords
			// If no, assign the input to an array of keywords as a single element
			$keywords = (strpos($param, " ") !== false) ? explode(" ", $param) : array($param);
			// Create a regular expression pattern from the keywords using a single function
			$pattern = "'(" . implode(".*", $keywords) . "|" . implode(".*", array_reverse($keywords)) . ")'";

			//** version 2.*/
			// assign =multiparam as =param, but check if input contains spaces
			// If yes, replace the spaces with .*
			// If no, =multiparam just as the same origin input =param.
			$multiparam = (strpos($param, " ") !== false) ? str_replace(' ', '.*', $param) : $param; //

			// in SQL queries REGEXP need () place param.
			$pattern = ($multiparam !== $param) ? "($multiparam)" : $multiparam; //

			/* version heredoc function
			// 'heredoc' function in new version php.
			// require at least php 7.4+
			$param = <<< PATTERN 
				(?=.*$param) 
			PATTERN;
			$param = str_replace(' ', ')(?=.*', $param);
			*/

			$query .= "
				AND (
					a.id REGEXP '$pattern'
					OR a.col2 REGEXP '$pattern'
					OR a.col3 REGEXP '$pattern'
					OR a.col4 REGEXP '$pattern'
					)
			";
		} else if ($param == "*" or $param == "") { // old version webpps use * as full search
			$query .= "
				AND a.col1 LIKE '%%'
			";
		}
	}
}
