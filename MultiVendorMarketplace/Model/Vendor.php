<?php

  namespace Vinsol\MultiVendorMarketplace\Model;

  class Vendor extends \Magento\Framework\Model\AbstractModel
  {
    const ENTITY = 'marketplace_vendor';
    const ADMIN_USER = 'admin_user';
    const ROLE_TABLE = 'authorization_role';
    const ROLE_NAME = 'vendor';
    protected $encryptor;
    protected $role;
    protected $user;
    protected $urlRewrite;

    public function __construct(
      \Magento\Framework\Encryption\Encryptor $encryptor,
      \Magento\Authorization\Model\RoleFactory $roleFactory,
      \Magento\Framework\Model\Context $context,
      \Magento\Framework\Registry $registry,
      \Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor $resource,
      // \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
      \Magento\User\Model\UserFactory $userFactory,
      // \Magento\User\Model\User $user,
      \Magento\UrlRewrite\Model\UrlRewriteFactory $urlRewriteFactory,
      array $data = []
    )
    {
      $this->encryptor = $encryptor;
      $this->user = $userFactory->create();
      // $this->user = $user;
      $this->role = $roleFactory->create();
      $this->urlRewrite = $urlRewriteFactory->create();
      // parent::__construct($context, $registry, $resource, $resourceCollection, $data);
      parent::__construct($context, $registry, $resource, null, $data);
    }

    protected function _construct()
    {
      $this->_init('Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor');
    }

    // public function setPassword($password, $salt = true)
    // {
    //   $this->setData('password', $this->encryptor->getHash($password, $salt));
    // }

    // public function setRoleId()
    // {
      // $this->setData('role_id', $this->role->load(self::ROLE_NAME, 'role_name')->setPageSize(1)->setCurPage(1)->getId());
    // }

    public function getStatus($id)
    {
      $this->user->load($id);
      $status = $this->user->getIsActive();
      return $status;
    }

    // public function getVendorUrl($vendorId)
    // {
      // $this->urlRewrite->load($vendorId);
    // }
  }