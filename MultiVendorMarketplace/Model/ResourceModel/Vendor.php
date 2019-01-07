<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

  use Magento\Framework\DataObject;

  class Vendor extends \Magento\Eav\Model\Entity\AbstractEntity
  {
    protected $user;

    public function __construct(
      \Magento\Eav\Model\Entity\Context $context,
      \Magento\User\Model\UserFactory $userFactory,
      $data = []
    )
    {
      $this->user = $userFactory->create();
      parent::__construct($context, $data);
    }
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

    protected function _beforeSave(DataObject $object)
    {
      // $data = ;
      // $this->user->load($id);
      // $this->user->setData($data);
      // $this->user->save();
      parent::_beforeSave($object);
    }
  }
