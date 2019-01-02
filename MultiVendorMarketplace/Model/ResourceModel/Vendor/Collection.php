<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor;

  class Collection extends \Magento\Eav\Model\Entity\Collection\AbstractCollection
  {
    
    protected function _construct()
    {
      $this->_init(
        'Vinsol\MultiVendorMarketplace\Model\Vendor', 
        'Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor'
      );
    }
  }

