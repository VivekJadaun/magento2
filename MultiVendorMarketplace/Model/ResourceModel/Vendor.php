<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

  class Vendor extends \Magento\Eav\Model\Entity\AbstractEntity
  {
    protected function _construct()
    {
      $this->_read = 'marketplace_vendor_read';
      $this->_write = 'marketplace_vendor_write';
    }

    public function getEntityType()
    {
      if(empty($this->_type)) {
        $this->setType(\Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY);
      }
      return parent::getEntityType();
    }
  }
