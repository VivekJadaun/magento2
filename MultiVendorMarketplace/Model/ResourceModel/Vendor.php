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
      // $this->messageManager->addNotice(http_build_query($data));
      // if ($this->user->getId()) {        //REMAIN COMMENTED
        $this->user->setData($data);
        try {
          $this->user->save();
          // $this->messageManager->addSuccess(__('User Saved.'));
        } catch (\Exception $e) {
          $this->messageManager->addException($e);
        }
      // } 
      $object->setUserId($this->user->getId());
      if (isset($_FILES['logo']['name'])) {
        $object->setLogo($_FILES['logo']['name']);
      }
      if (isset($_FILES['banner']['name'])) {
        $object->setBanner($_FILES['banner']['name']);
      }
      parent::_beforeSave($object);
    }

    protected function _afterDelete(DataObject $object)
    {
      $this->user->load($object->getUserId());
      $this->user->delete();
      parent::_afterDelete($object);
    }
  }
