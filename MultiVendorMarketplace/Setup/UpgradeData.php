<?php

  namespace Vinsol\MultiVendorMarketplace\Setup;

  use Magento\Framework\Setup\UpgradeDataInterface;
  use Magento\Framework\Setup\ModuleContextInterface;
  use Magento\Framework\Setup\ModuleDataSetupInterface;
  use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

  class UpgradeData implements UpgradeDataInterface
  {
    const USER_ID = 'user_id';
    protected $eavSetupFactory;
    protected $vendorFactory;
    protected $encryptor;
    protected $dateTimeFactory;
    protected $role;

    public function __construct(
      \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
      \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
      \Magento\Framework\Encryption\Encryptor $encryptor,
      \Magento\Framework\Intl\DateTimeFactory $dateTimeFactory,
      \Magento\Authorization\Model\RoleFactory $roleFactory,
      AttributeSetFactory $attributeSetFactory
    )
    {
      $this->eavSetupFactory = $eavSetupFactory;  
      $this->vendorFactory = $vendorFactory;
      $this->encryptor = $encryptor;
      $this->dateTimeFactory = $dateTimeFactory;
      $this->role = $roleFactory->create();
      $this->attributeSetFactory = $attributeSetFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
      $setup->startSetup();
      if (version_compare($context->getVersion(), '1.1.1', '>')) {

        $productSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        // $attributeSet = $this->attributeSetFactory->create();
        // $productTypeId = $productSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        // $attributeSetId = $productSetup->getDefaultAttributeSetId($productTypeId);
        // $data = [
        //   'attribute_set_name' => \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET,
        //   'entity_type_id' => $productTypeId,
        //   'sort_order' => 2,
        // ];
        // $attributeSet->setData($data)->validate();
        // $attributeSet->save();

        // $productSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, self::USER_ID, 'attribute_set', \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET); 
        // $productSetup->updateAttributeSet(4, 17, );

        
        // $vendor = $this->vendorFactory->create();

        // $vendor->setData([
        //   'display_name' => 'test_vendor',
        //   'username' => 'test_vendor',
        //   'password' => $this->encryptor->getHash('password', true),
        //   'created_at' => $this->dateTimeFactory->create()->getTimestamp(),
        //   'is_active' => 1,
        //   'commission_perc' => 40.00,
        //   'contact_no' => '9383325824',
        //   'email' => 'testvendor@example.com',
        //   'role_id' => $this->role->load(\Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME, 'role_name')->getId(),
        //   'sort_order' => 10,
        //   'first_name' => 'test',
        //   'last_name' => 'vendor',
        //   'address' => '1/4 West Patel Nagar'
        // ]);
        // $vendor->save();
      }

      $setup->endSetup();
    }
  }