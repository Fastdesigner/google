<?php

namespace google;

class BusinessProfile extends Google {
	protected $accountManagement = 'https://mybusinessaccountmanagement.googleapis.com/v1';
	protected $businessInformation = 'https://mybusinessbusinessinformation.googleapis.com/v1';
	protected $businessProfile = 'https://mybusiness.googleapis.com/v4';

	public function accounts($pageSize = 20, $pageToken = '') {
		$query = ['pageSize'=>max(1,min(100,intval($pageSize)))];
		if (trim((string) $pageToken) !== '') $query['pageToken'] = trim((string) $pageToken);
		return $this->request($this->accountManagement.'/accounts',$query);
	}

	public function locations($accountName, $readMask = 'name,title,storeCode,metadata', $pageSize = 100, $pageToken = '') {
		$accountName = $this->accountName($accountName);
		if ($accountName == '') return false;
		$query = ['readMask'=>$readMask,'pageSize'=>max(1,min(100,intval($pageSize)))];
		if (trim((string) $pageToken) !== '') $query['pageToken'] = trim((string) $pageToken);
		return $this->request($this->businessInformation.'/'.$accountName.'/locations',$query);
	}

	public function reviews($accountName, $locationName, $pageSize = 50, $pageToken = '', $orderBy = 'updateTime desc') {
		$parent = $this->reviewParent($accountName,$locationName);
		if ($parent == '') return false;
		$query = ['pageSize'=>max(1,min(50,intval($pageSize)))];
		if (trim((string) $pageToken) !== '') $query['pageToken'] = trim((string) $pageToken);
		if (trim((string) $orderBy) !== '') $query['orderBy'] = trim((string) $orderBy);
		return $this->request($this->businessProfile.'/'.$parent.'/reviews',$query);
	}

	protected function accountName($accountName) {
		$accountName = trim((string) $accountName,'/');
		if ($accountName == '') return '';
		return strpos($accountName,'accounts/') === 0 ? $accountName : 'accounts/'.$accountName;
	}

	protected function reviewParent($accountName, $locationName) {
		$locationName = trim((string) $locationName,'/');
		if ($locationName == '') return '';
		if (strpos($locationName,'accounts/') === 0) return $locationName;
		$accountName = $this->accountName($accountName);
		if ($accountName == '') return '';
		return $accountName.'/'.(strpos($locationName,'locations/') === 0 ? $locationName : 'locations/'.$locationName);
	}
}
