<?php

namespace App\Services;


class GroupService {
	public static function generateEnrollCode() {
		$hash = md5(uniqid(rand(), true));
		$slit = substr($hash, 0, 4);
		return strtoupper($slit);
	}
}