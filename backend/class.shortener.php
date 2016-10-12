<?php

/**
 * Very ugly object for fetching data from database and creating short urls.
 * @author JokkeeZ
 * @version 12/10/2016 (dd.mm.yy)
 */
class Shortener {

	private $longUrl;
	private $shortUrl;

	/**
	 * Creates simple hash using given url and current timestamp, hashed with md5.
	 * @return string Returns "hashed" shorten url ending.
	 */
	public function createHash($url) {
		$this->longUrl = $url;

		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
		$timeValue = $d->format("Y-m-d H:i:s.u");

		$random = rand(0, 99999);
		$timeValue = $timeValue . $url . $random;

		$this->shortUrl = md5($timeValue);
		return $this->shortUrl;
	}

	/**
	 * Check's if longurl exists on database.
	 * @return Boolean Returns true if longurl exists on database.
	 */
	public function linkExistsOnDatabase() {
		$stmt = Core::getDatabase()->prepare('SELECT * FROM links WHERE long_link = :long LIMIT 1');
		$stmt->execute([':long' => $this->longUrl]);

		return ($stmt->rowCount() > 0);
	}

	/**
	 * Add's new row to database, with given long- and shorturl.
	 * @return void
	 */
	public function addLinkToDatabase() {
		$this->fixLongUrls();
		$stmt = Core::getDatabase()->prepare('INSERT INTO links (long_link, short_link) VALUES (:long, :short)');
		$stmt->execute([':long' => $this->longUrl, ':short' => $this->shortUrl]);
	}

	/**
	 * Really stupid and simple "fix" for checking if longurl contains "http" || "https".
	 * It's ugly just cuz I'm lazy.
	 * @return void
	 */
	public function fixLongUrls() {
		$long = $this->longUrl;

		if (substr($long, 0, 7) != "https://" || substr($long, 0, 6) != "http://") {
			$long = "http://" . $long;
		}

		$this->longUrl = $long;
	}

	/**
	 * Get's shorturl from database by seaching longurl on same row.
	 * @return string Returns shorturl if exists, otherwise servers baseurl.
	 */
	public function getShortLinkByLong($long) {
		$stmt = Core::getDatabase()->prepare('SELECT short_link FROM links WHERE long_link = :long LIMIT 1');
		$stmt->execute([':long' => $long]);

		if ($stmt->rowCount() > 0) {
			$data = $stmt->fetch();
			return $data['short_link'];
		}

		return Core::getBaseUrl();
	}

	/**
	 * Get's longurl from database by seaching shorturl on same row.
	 * @return string Returns longurl if exists, otherwise servers baseurl.
	 */
	public function getLongLinkByShortener($short) {
		$stmt = Core::getDatabase()->prepare('SELECT long_link FROM links WHERE short_link = :short LIMIT 1');
		$stmt->execute([':short' => $short]);

		if ($stmt->rowCount() > 0) {
			$data = $stmt->fetch();
			return $data['long_link'];
		}

		return Core::getBaseUrl();
	}

	/**
	 * Put's all together for complete shorturl.
	 * @return string Returns shotener url.
	 */
	public function generateNewShortLink($short) {
		return Core::getBaseUrl() . "/s/" . $short;
	}

	/**
	 * Put's all together for complete shorturl.
	 * @return string Returns shotener url.
	 */
	public function generateNewLink() {
		return Core::getBaseUrl() . "/s/" . $this->shortUrl;
	}
}