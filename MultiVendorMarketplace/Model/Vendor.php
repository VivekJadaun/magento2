<?php

  namespace Vinsol\MultiVendorMarketplace\Model;

  /**
   * 
   */
  class Vendor extends \Magento\Framework\Model\AbstractModel
  {
    const ENTITY = 'marketplace_vendor';
    const ROLE_NAME = 'vendor';
    protected $encryptor;
    protected $role;

    public function __construct(
      \Magento\Framework\Encryption\Encryptor $encryptor,
      \Magento\Authorization\Model\RoleFactory $roleFactory,
      \Magento\Framework\Model\Context $context,
      \Magento\Framework\Registry $registry,
      \Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor $resource,
      \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
      array $data = []
    )
    {
      $this->encryptor = $encryptor;
      $this->role = $roleFactory->create();
      parent::__construct(
        $context,
        $registry,
        $resource,
        $resourceCollection,
        $data
      );
    }

    protected function _construct()
    {
      $this->_init('Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor');
    }

    public function setPassword($password, $salt = true)
    {
      $this->setData('password', $this->encryptor->getHash($password, $salt));
    }

    public function setRoleId()
    {
      $this->setData('role_id', $this->role->load(self::ROLE_NAME, 'role_name')->setPageSize(1)->setCurPage(1)->getId());
    }
  }