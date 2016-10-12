<?php

/**
 * Very simple PDO "wrapper" for creating simple database instance.
 * @author JokkeeZ
 * @version 12/10/2016 (dd.mm.yy)
 */
class Database extends PDO {

	/**
	 * Initializes PDO instance with given values.
	 * @throws PDOException if creating new instance failed.
	 * @param $host Database hostname, used for connecting Database server.
	 * @param $username Database username, used to validate Database session.
	 * @param $password Database password, used to validate Database session.
	 * @param $database Database databases name, used for getting data from right tables etc.
	 */
	public function __construct($host, $username, $password, $database) {
		try {
			parent::__construct('mysql:host=' . $host . ';dbname=' . $database, $username, $password);
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}