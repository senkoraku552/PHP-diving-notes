<?php

class Dbh
{
	// upblic for global usage
	public $pdo;

	// Default setting
	private $host = 'localhost';
	private $dbName = 'test_oop';
	private $user = 'dbadmin';
	private $pwd = 'P@ssw8833rd';

	public function __construct()
	// for swich multi-db 
/* 	public function __construct(
		$db = null, $user = null, $pwd = null, $options
	) */
	
	// usage (in other page);
	// $dbName = new Dbh($db, $user, $pwd, $options);
	{
		// pdo dsn official setting
		$dsn = "mysql:host=$this->host;dbname=$this->dbName;charset=utf8mb4";

		// default options
		// FETCH_ASSOC for separate with 'class->oop' methods
		$df_Options = [
			PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => FALSE,
		];

		// conditional options
		// operateer(? :) in (if...else...) conditions
		$options = (isset($options)) ? array_replace($df_Options, $options) : $df_Options;

		// Std try-catch PDO
		try {
			$this->pdo = new PDO($dsn, $this->user, $this->pwd, $options);

		} catch (\PDOException $e) {
			throw new \Exception(
				$e->getMessage(),
				(int)$e->getCode(),
			);
		}

		// end of function return $pdo result
		return $this->pdo;
	}
}