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
      \Magento\Authorization\Model\RoleFactory $roleFactory
    )
    {
      $this->vendorFactory = $vendorFactory;
      $this->encryptor = $encryptor;
      $this->dateTimeFactory = $dateTimeFactory;
      $this->role = $roleFactory->create();
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
      $setup->startSetup();
      var_dump($this->role->addFieldToFilter('role_name', 'vendor')->setPageSize(1)->setCurPage(1)->load());
      if (version_compare($context->getVersion(), '1.0.0', '<=')) {
        $vendor = $this->vendorFactory->create();

        $vendor->setData([
          'display_name' => 'test_vendor',
          'username' => 'test_vendor',
          'password' => $this->encryptor->getHash('password', true),
          'created_at' => $this->dateTimeFactory->create()->getTimestamp(),
          'is_active' => 1,
          'commission_perc' => 40.00,
          'contact_no' => '9383325824',
          'email' => 'testvendor@example.com',
          'role_id' => $this->role->addFieldToFilter('role_name', 'vendor')->setPageSize(1)->setCurPage(1)->load()->getId(),
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