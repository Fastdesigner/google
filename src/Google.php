<?php

namespace google;

class Google {
	protected $accountRef = 'default';
	protected $last = [];

	public function __construct($accountRef = 'default') {
		$this->accountRef = trim((string) $accountRef) !== '' ? trim((string) $accountRef) : 'default';
	}

	public function last() {
		return $this->last;
	}

	protected function request($url, $query = [], $method = 'GET', $payload = []) {
		$this->last = ['result'=>false,'code'=>0,'body'=>[],'error'=>''];
		$auth = \oauth\OAuth::get_request('google',$this->accountRef);
		if (!$auth) {
			$this->last['error'] = \oauth\OAuth::last_error() != '' ? \oauth\OAuth::last_error() : 'oauth_unavailable';
			return false;
		}
		if (!empty($query)) $url .= (strpos($url,'?') === false ? '?' : '&').http_build_query($query);
		$result = \curl__request($url,$auth['headers'],$payload,'','','',$method);
		if ($result === false) {
			$this->last['error'] = 'request_failed';
			return false;
		}
		$this->last['code'] = intval($result['code'] ?? 0);
		$this->last['error'] = trim((string) ($result['error'] ?? ''));
		$this->last['body'] = json_decode($result['body'] ?? '',true);
		if (!is_array($this->last['body'])) $this->last['body'] = [];
		$this->last['result'] = $result !== false && $this->last['error'] == '' && $this->last['code'] >= 200 && $this->last['code'] < 300;
		return $this->last['result'] ? $this->last['body'] : false;
	}
}
