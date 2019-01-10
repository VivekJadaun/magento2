<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

  use Magento\Framework\DataObject;

  class Vendor extends \Magento\Eav\Model\Entity\AbstractEntity
  {
    protected $user;
    protected $messageManager;

    public function __construct(
      \Magento\Eav\Model\Entity\Context $context,
      \Magento\User\Model\UserFactory $userFactory,
      \Magento\Framework\Message\Manager $messageManager,
      $data = []
    )
    {
      $this->user = $userFactory->create();
      $this->messageManager = $messageManager;
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

      $data = $object->getData();
      // var_dump($data);
      // $data['role_name'] = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME;
      $this->user->setData($data);
      $this->user->save();
      parent::_beforeSave($object);
    }
  }
