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

    // protected function _afterLoad(DataObject $object)
    // {
      // parent::_afterLoad($object);
    // }

    protected function _beforeSave(DataObject $object)
    {
      $object->setUserType(\Magento\Authorization\Model\UserContextInterface::USER_TYPE_GUEST);
      $data = $object->getData();
      $this->user->load($object->getUserId());
      if ($this->user->getId()) {
      // $msg = implode(', ', $this->user->getData());
      // $msg = implode(', ', $data);
        // var_dump($this->user->getData());
        // $this->messageManager->addNotice("Object['data'] : $msg");
        // $this->messageManager->addNotice("Object['data']['id'] : $this->user->getId()");
        // $this->messageManager->addNotice(implode(', ', $this->user->getData()));
        $this->user->setData($data);
        try {
          $this->user->save();
          
        } catch (\Exception $e) {
          $this->messageManager->addException($e);
        }
      }
      $object->setUserId($this->user->getId());
      parent::_beforeSave($object);
    }

    protected function _afterDelete(DataObject $object)
    {
      $this->user->load($object->getUserId());
      $this->user->delete();
      parent::_afterDelete($object);
    }
  }
