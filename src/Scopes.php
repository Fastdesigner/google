<?php

namespace google;

class Scopes {
	public const BUSINESS_PROFILE = 'https://www.googleapis.com/auth/business.manage';
	public const SEARCH_CONSOLE_READONLY = 'https://www.googleapis.com/auth/webmasters.readonly';
	public const SEARCH_CONSOLE = 'https://www.googleapis.com/auth/webmasters';

	public static function businessProfile() {
		return [self::BUSINESS_PROFILE];
	}

	public static function searchConsole() {
		return [self::SEARCH_CONSOLE_READONLY];
	}
}
