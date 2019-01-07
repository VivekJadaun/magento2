<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor;

  class Collection extends \Magento\Eav\Model\Entity\Collection\AbstractCollection
  {

    const ADMIN_USER_VENDOR_ENTITY_FIELDS = array(
      'firstname' => 'firstname', 
      'lastname' => 'lastname', 
      'email' => 'email', 
      'username' => 'username', 
      'created' => 'created', 
      'is_active' => 'is_active'
    );
    const ROLE_FIELDS = array(
      'role_id' => 'role_id', 
      'role_name' => 'role_name'
    );

    protected $mainTable = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY . '_entity';
    protected $adminUserTable = \Vinsol\MultiVendorMarketplace\Model\Vendor::ADMIN_USER;
    protected $roleTable = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_TABLE;
    protected $roleName = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME;
    
    protected function _construct()
    {
      $this->_init(
        'Vinsol\MultiVendorMarketplace\Model\Vendor', 
        'Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor'
      );
    }

    protected function _initSelect()
    {
      parent::_initSelect();

      $where = "role_name = '$this->roleName'";
      $this->joinTable($this->adminUserTable, 'user_id=user_id', self::ADMIN_USER_VENDOR_ENTITY_FIELDS);
      $this->joinTable($this->roleTable, 'user_id=user_id', self::ROLE_FIELDS, $where, 'inner');
      return $this;
    }
  }

