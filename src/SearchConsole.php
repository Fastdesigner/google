<?php

namespace google;

class SearchConsole extends Google {
	protected $endpoint = 'https://www.googleapis.com/webmasters/v3';

	public function sites() {
		return $this->request($this->endpoint.'/sites');
	}

	public function site($siteUrl) {
		$siteUrl = trim((string) $siteUrl);
		if ($siteUrl == '') return false;
		return $this->request($this->endpoint.'/sites/'.rawurlencode($siteUrl));
	}

	public function query($siteUrl, $body = []) {
		$siteUrl = trim((string) $siteUrl);
		if ($siteUrl == '') return false;
		return $this->request($this->endpoint.'/sites/'.rawurlencode($siteUrl).'/searchAnalytics/query',[],'POST',$body,['Content-Type: application/json']);
	}

	public function queryPages($siteUrl, $query, $startDate, $endDate, $rowLimit = 100) {
		$query = trim((string) $query);
		if ($query == '') return false;
		return $this->query($siteUrl,[
			'startDate'=>$startDate,
			'endDate'=>$endDate,
			'dimensions'=>['page'],
			'type'=>'web',
			'rowLimit'=>max(1,min(25000,intval($rowLimit))),
			'dimensionFilterGroups'=>[[
				'groupType'=>'and',
				'filters'=>[[
					'dimension'=>'query',
					'operator'=>'equals',
					'expression'=>$query
				]]
			]]
		]);
	}
}
