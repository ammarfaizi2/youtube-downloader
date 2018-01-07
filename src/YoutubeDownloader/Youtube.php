<?php

namespace YoutubeDownloader;

use YoutubeDownloader\YoutubeDownloaderException;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @version 0.0.1
 */
class Youtube
{
	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $bin;

	/**
	 * @param string $url
	 */
	public function __construct($url)
	{
		$this->url = str_replace("\"", "\\\"", $url);
		$this->bin = __DIR__."/../../bin/youtube-dl";
	}

	public function listFormat()
	{
		preg_match_all('/((\d{2,4})(\s{1,15})(mp4|webm|3gp|m4a|mp3)(\s{1,15})((\d{2,4}x\d{2,4})|audio\s{1,3}only)\s{1,15}(.*)\n)/', shell_exec(
			$this->bin." --list-format \"".$this->url."\" 2>&1" 
		), $matches, PREG_SET_ORDER, 0);
		$result = [];
		foreach ($matches as $key => $val) {
			if (count($val) === 9) {
				$result[trim($val[2])] = [
					"extension" => trim($val[4]),
					"resolution" => trim($val[6]),
					"description" => trim($val[8])
				];
			}
		}
		return $result;
	}

	/**
	 * @throws \YoutubeDownloader\YoutubeDownloaderException
	 * @param string $path
	 * @param int $format
	 * @return mixed
	 */
	public function download($path = ".", $format = null)
	{
		$path = realpath($path);
		if (empty($path)) {
			throw new YoutubeDownloaderException("Invalid path!");
		} else {
			if (! is_numeric($format)) {
				throw new YoutubeDownloaderException("Invalid format!");
			} else {
				$format = "-f ".$format;
				$stdout = shell_exec("cd ".$path." && ".$this->bin." ".$this->url." ".$format." 2>&1");
				if (strpos($stdout, "ERROR: requested format not available") !== false) {
					throw new YoutubeDownloaderException("Error: requested format not available", 1);
				}
			}
		}
		if (preg_match("/Destination:\s(.*)\\n/", $stdout, $matches) and isset($matches[1])) {
			return $matches[1];
		}
		return false;
	}
}
