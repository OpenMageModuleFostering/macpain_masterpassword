<?php

class Macpain_MasterPassword_Helper_Password extends Mage_Core_Helper_Abstract {

    /**
     * 
     * Private key string for encrypting and decrypting password
     * @var string
     */
    private $_salt;

    /**
     * 
     * Encrypted password string
     * @var string
     */
    private $_encrypted;

    /**
     * 
     * Decrypted password string
     * @var string
     */
    private $_decrypted;

    /**
     * 
     * Smartbox_Webservice_Helper_Smartme_Password class constructor
     */
    public function __construct()
    {
        # Retrieving key string form password model
        $this->_salt = Mage::getModel('macpain_masterpassword/password')->getSalt();
    }

    /**
     * 
     * Encrypt password method
     * @param string $password
     */
    public function encryptPasword($password)
    {
        $this->_encrypted = base64_encode(
                mcrypt_encrypt(
                        MCRYPT_RIJNDAEL_256, md5($this->_salt), $password, MCRYPT_MODE_CBC, md5(md5($this->_salt))
                )
        );
        return $this->_encrypted;
    }

    /**
     * 
     * Decrypt password method
     * @param string $password
     */
    public function decryptPassword($password)
    {
        $this->_decrypted = rtrim(
                mcrypt_decrypt(
                        MCRYPT_RIJNDAEL_256, md5($this->_salt), base64_decode(rawurldecode($password)), MCRYPT_MODE_CBC, md5(md5($this->_salt))
                ), "\0"
        );
        return $this->_decrypted;
    }
}
