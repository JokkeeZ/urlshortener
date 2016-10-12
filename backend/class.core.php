<?php

include_once 'class.database.php';
include_once 'class.shortener.php';

/**
 * Core class initializes database and url shortener classes.
 * @author JokkeeZ
 * @version 12/10/2016 (dd.mm.yy)
 */
class Core {

	private static $database;
	private static $shortener;

	/**
	 * Get's initialized Database object.
	 * @return Database instance.
	 */
	public static function getDatabase() {
		return self::$database;
	}

	/**
	 * Get's initialized Shortener object.
	 * @return Shortener instance.
	 */
	public static function getShortener() {
		return self::$shortener;
	}

	/**
	 * Initializes Database and Shortener classes.
	 */
	public static function initialize() {
		self::$database = new Database('localhost', 'root', '', 'shorturls');
		self::$shortener = new Shortener();
	}

	/**
	 * Get's servers base url.
	 * @see http://stackoverflow.com/a/2820771
	 * @example "http://localhost/"
	 */
	public static function getBaseUrl() {
		return sprintf(
			"%s://%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME']
		);
	}
}