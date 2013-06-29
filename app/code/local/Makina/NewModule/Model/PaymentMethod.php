<?php

// Makina test CC module adapter

class Makina_NewModule_Model_PaymentMethod extends Mage_Payment_model_Method_Cc
{
	//unique internal payment method identifier
	protected $_code = 'newmodule';

	/**
	* Here are examples of flags that will determine functionality availability
	* of this module to be used by frontend and backend.
	*
	* @see all flags and their defaults in Mage_Payment_Model_Method_Abstract
	*
	* It is possible to have a custom dynamic logic by overloading
	* public function can* for each flag respectively
	*/

	protected $_isGateway = true;
	protected $_canAuthorize = true;
	protected $_canCapture = true;
	protected $_canCapturePartial = false;
	protected $_canRefund = false;
	protected $_canVoid = true;
	protected $_canUseInternal = true;
	protected $_canUseCheckout = true;
	protected $_canUseForMultishipping = true;
	protected $_canSaveCc = false;

	/**
	* Here you will need to implement authorize, capture and void public methods
	*
	* @see examples of transaction specific public methods such as
	* authorize, capture and void in Mage_Paygate_Model_Authorizenet
	*/
	


}