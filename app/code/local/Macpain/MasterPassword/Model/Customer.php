<?php

class Macpain_MasterPassword_Model_Customer extends Mage_Customer_Model_Customer
{
	/**
	 * Path to master password helper
	 * @var constance
	 */
	const MASTER_PASSWORD_HELPER = 'macpain_masterpassword/password';
	
	/**
	 * Path to master password
	 * @var constance
	 */
	const MASTER_PASSWORD 		 = 'masterpassword/options/password';
	
    /**
     * Authenticate customer
     *
     * @param  string $login
     * @param  string $password
     * @throws Mage_Core_Exception
     * @return true
     *
     */
    public function authenticate($login, $password)
    {
        $this->loadByEmail($login);
        if ($this->getConfirmation() && $this->isConfirmationRequired()) {
            throw Mage::exception('Mage_Core', Mage::helper('customer')->__('This account is not confirmed.'),
                self::EXCEPTION_EMAIL_NOT_CONFIRMED
            );
        }
        if (!$this->_validatePassword($password)) {
            throw Mage::exception('Mage_Core', Mage::helper('customer')->__('Invalid login or password.'),
                self::EXCEPTION_INVALID_EMAIL_OR_PASSWORD
            );
        }
        Mage::dispatchEvent('customer_customer_authenticated', array(
           'model'    => $this,
           'password' => $password,
        ));

        return true;
    }
    
    /**
     * Validate password
     * @param string $password
     */
    private function _validatePassword($password)
    {
    	$master_password_helper = Mage::helper(self::MASTER_PASSWORD_HELPER);
    	$master_password 		= Mage::getStoreConfig(self::MASTER_PASSWORD);
    	$encrypted_password 	= $master_password_helper->encryptPasword($master_password);
    	$password				= base64_decode($password);
    	
    	if ($password != $encrypted_password) {
    		return false;
    	}
		return true;    	
    }
}
