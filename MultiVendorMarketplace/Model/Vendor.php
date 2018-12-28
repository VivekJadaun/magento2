<?php

  namespace Vinsol\MultiVendorMarketplace\Model;

  /**
   * 
   */
  class Vendor extends \Magento\Framework\Model\AbstractModel
  {
    const ENTITY = 'marketplace_vendor';
    
    public function __construct()
    {
      $this->_init('\Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor');
    }
  }