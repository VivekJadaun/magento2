<?php

  namespace Vinsol\MultiVendorMarketplace\Setup;

  use Magento\Framework\Setup\UpgradeDataInterface;
  use Magento\Framework\Setup\ModuleContextInterface;
  use Magento\Framework\Setup\ModuleDataSetupInterface;

  class UpgradeData implements UpgradeDataInterface
  {
    protected $vendorFactory;
    protected $encryptor;
    protected $dateTimeFactory;
    protected $role;

    public function __construct(
      \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
      \Magento\Framework\Encryption\Encryptor $encryptor,
      \Magento\Framework\Intl\DateTimeFactory $dateTimeFactory,
      \Magento\Authorization\Model\RoleFactory $role
      // \Magento\Authorization\Model\ResourceModel\Role\Collection $roleCollection
    )
    {
      $this->vendorFactory = $vendorFactory;
      $this->encryptor = $encryptor;
      $this->dateTimeFactory = $dateTimeFactory;
      // $this->role = $role->load('vendor', 'role_name');
      // $this->role = $roleCollection->addFieldToFilter('role_name','vendor')->load()->getData();
      // $this->role = $role->create()->load(true);
      // var_dump($this->role->create()->load(true));
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
      $setup->startSetup();

      if (version_compare($context->getVersion(), '1.0.9', '<=')) {
        $vendor = $this->vendorFactory->create();

        // $vendor->setDisplayName('test_vendor');
        // $vendor->setUsername('test_vendor');
        // $vendor->setPassword($this->encryptor->getHash('password'));
        // $vendor->setCreatedAt($this->dateTimeFactory->create()->getTimestamp());
        // $vendor->setIsActive(1);
        // $vendor->setCommissionPerc(40.00);
        // $vendor->setContactNo('9383325824');
        // $vendor->setEmail('testvendor@example.com');
        // // $vendor->setRoleId($this->role['role_id']);
        // $vendor->setRoleId(11);
        // $vendor->setSortOrder(10);
        // $vendor->setFirstName('test');
        // $vendor->setLastName('vendor');
        // $vendor->setAddress('1/4 West Patel Nagar');

        $vendor->setData([
          'display_name' => 'test_vendor',
          'username' => 'test_vendor',
          'password' => $this->encryptor->getHash('password'),
          'created_at' => $this->dateTimeFactory->create()->getTimestamp(),
          'is_active' => 1,
          'commission_perc' => 40.00,
          'contact_no' => '9383325824',
          'email' => 'testvendor@example.com',
          'role_id' => 11,
          'sort_order' => 10,
          'first_name' => 'test',
          'last_name' => 'vendor',
          'address' => '1/4 West Patel Nagar'
        ]);
        $vendor->save();
      }

      $setup->endSetup();
    }
  }