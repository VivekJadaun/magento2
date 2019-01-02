<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor;

  class Collection extends \Magento\Eav\Model\Entity\Collection\AbstractCollection
  {

    protected $mainTable = 'marketplace_vendor_entity';
    protected $rolesTable = 'authorization_role';
    
    protected function _construct()
    {
      $this->_init(
        'Vinsol\MultiVendorMarketplace\Model\Vendor', 
        'Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor'
      );
    }

    public function vendorsWithRoles()
    {
      $this->getTable($this->rolesTable);
    }

  }

