<?php

class SearchData extends Dbh
{
  protected string $query;
  protected string $multi_param;
  protected string $pattern;

  public function multi_param_search($param)
  {
    // define first query statement and initial with 1=1 anywhere query.
    $this->query = " SELECT columns FROM `table` 
		WHERE 1 = 1
		";

    // in SQL statement REGEXP function read "()" as pattern
    if ($param !== "") { // check for input parameters

      // origin logic root
      // pre define $this->multi_param read $param
      // new version PHP does not need determining empty space
      $this->multi_param = str_replace(' ', '.*', $this->multi_param);
      // process $this->multi_param into $pattern let sql query work
      if ($this->multi_param !== $param) {
        $this->pattern = "({$this->multi_param})";
      } else {
        $this->pattern = $this->multi_param; // else do single REGEXP
      }

      // ----------------------------------------------------------------
      // reverse elasticsearch
      // convert $param as array
      if (is_string($param)) {
        $this->multi_param = explode(' ', $param);
      } else {
        $this->multi_param = array($param);
      }

      // merge both array as strings into pattern to do elasticsearch
      if (is_array($this->multi_param)) {
        $this->pattern = sprintf("'(%s|%s)'", implode(".*", $this->multi_param), implode(".*", array_reverse($this->multi_param)));
      } else {
        echo "Error: Input parameters does not match any of the pattern in database.";
        return false;
      }
      // -pattern output => "(a.*b)|(b.*a)";

      // ----------------------------------------------------------------
      // deprecated 2023 since found `sprintf` function
      // $this->pattern = "'(";
      // $this->pattern .= implode(".*", $this->multi_param) . "|" . implode(".*", array_reverse($this->multi_param));
      // $this->pattern .= ")'";
      // output => '(abc.*xyz|xyz.*abc)'
      // ----------------------------------------------------------------

      /* ternary operator versions */
      // origin version
      $this->multi_param = str_replace(' ', '.*', $this->multi_param);
      $this->pattern = ($this->multi_param !== $param) ? "({$this->multi_param})" : $this->multi_param;

      // reverse elasticsearch version
      // pattern only work array, otherwise please use `if...else` syntax
      $this->multi_param = is_string($param) ? explode(" ", $param) : array($param);
      $this->pattern = sprintf("'(%s|%s)'", implode(".*", $this->multi_param), implode(".*", array_reverse($this->multi_param)));

      // ----------------------------------------------------------------
      /* version heredoc function
			// 'heredoc' function in new version php.
			// require at least php 7.4+
			$param = <<< PATTERN 
				(?=.*$param) 
			PATTERN;
			$param = str_replace(' ', ')(?=.*', $param);
			*/
      // ----------------------------------------------------------------

      $this->query .= "
				AND (
					a.id REGEXP '{$this->pattern}'
					OR a.col2 REGEXP '{$this->pattern}'
					OR a.col3 REGEXP '{$this->pattern}'
					OR a.col4 REGEXP '{$this->pattern}'
					)
			";
    } else if ($param == "*" or $param == "") { // old version webpps use * as full search
      $this->query .= "
				AND a.col1 LIKE '%%'
			";
    } else { // place holder for error messages
    }

    $stmt = $this->pdo->prepare($this->query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
