<?php

class Macpain_MasterPassword_Model_Password extends Mage_Api_Model_Resource_Abstract
{
	/**
	 * 
	 * Private key string for encrypting and decrypting password
	 * @var string
	 */
	private $_salt;
	
	/**
	 * 
	 * Macpain_MasterPassword_Model_Password class constructor
	 */
	public function __construct()
	{
		$this->_salt = Mage::getStoreConfig('masterpassword/options/salt') . $this->_getActualDate();
	}
	
	/**
	 * 
	 * Getting key string
	 */
	public function getSalt()
	{
		return $this->_salt;
	}
	
	private function _getActualDate()
	{
		$date = new Zend_Date();
		return $date->get(Zend_Date::YEAR.Zend_Date::MONTH.Zend_Date::DAY);
	}
}