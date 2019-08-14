<?php

class Macpain_MasterPassword_Helper_Data extends Mage_Core_Helper_Data
{
	public function getLoginPostUrl()
    {
        return $this->_getUrl('masterpassword/index/loginpost');
    }
}