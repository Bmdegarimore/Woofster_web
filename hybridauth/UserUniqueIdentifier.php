<?php
	class UserUniqueIdentifier {
		public $uniqueId = ''; 

		//This object must construct using the uid and the provider
		public function __construct($uid, $provider) {
			$this->uniqueId = '' . $uid . '_' . $provider . '';
		}
	}
?>