<?php

  namespace Vinsol\MultiVendorMarketplace\Setup;

  use Magento\Framework\Setup\UpgradeDataInterface;
  use Magento\Framework\Setup\ModuleContextInterface;
  use Magento\Framework\Setup\ModuleDataSetupInterface;
  use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

// REMOVE THIS CLASS IN LIU OF INSTALL DATA
  
  class UpgradeData implements UpgradeDataInterface
  {
    const USER_ID = 'user_id';
    protected $eavSetupFactory;
    protected $vendorFactory;
    protected $encryptor;
    protected $dateTimeFactory;
    protected $role;
    protected $rules;

    public function __construct(
      \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
      \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
      \Magento\Framework\Encryption\Encryptor $encryptor,
      \Magento\Framework\Intl\DateTimeFactory $dateTimeFactory,
      \Magento\Authorization\Model\RoleFactory $roleFactory,
      \Magento\Authorization\Model\RulesFactory $rulesFactory,
      AttributeSetFactory $attributeSetFactory
    )
    {
      $this->eavSetupFactory = $eavSetupFactory;  
      $this->vendorFactory = $vendorFactory;
      $this->encryptor = $encryptor;
      $this->dateTimeFactory = $dateTimeFactory;
      $this->role = $roleFactory->create();
      $this->rules = $rulesFactory->create();
      $this->attributeSetFactory = $attributeSetFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
      $setup->startSetup();
      if (version_compare($context->getVersion(), '1.1.1', '<')) {

        echo ' upgrade data ';

      // $permitted_resources = [
        // 'Magento_Backend::dashboard', 
        // 'Vinsol_MultiVendorMarketplace::vendors',
        // 'Vinsol_MultiVendorMarketplace::vendors_products',
        // 'Magento_Catalog::products'
      // ];
      // $this->rules->setRoleId(3)
      //             ->setResources($permitted_resources)
      //             ->saveRel();        
        // $productSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        // $productSetup->setDefaultSetToEntityType(\Magento\Catalog\Model\Product::ENTITY, \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET);
        // $attributeSet = $this->attributeSetFactory->create();
        // $productTypeId = $productSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        // $attributeSetId = $productSetup->getDefaultAttributeSetId($productTypeId);
        // $data = [
        //   'attribute_set_name' => \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET,
        //   'entity_type_id' => $productTypeId,
        //   'sort_order' => 0,
        // ];
        // $attributeSet->setData($data)->validate();
        // $attributeSet->save();
        // $attributeSet->initFromSkeleton($attributeSetId);
        // $attributeSet->save();

        // $productSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, self::USER_ID, 'attribute_set', \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET); 

        // $productSetup->addAttributeToSet(\Magento\Catalog\Model\Product::ENTITY, \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET, 'General', \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID);

        $vendorSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $vendorSetup->updateAttribute(\Vinsol\MultiVendorMarketplace\Setup\InstallData::VENDOR_ENTITY, 'logo', 'backend_type', 'varchar');
        // echo 'logo label done';
        // $vendorSetup->updateAttribute(\Vinsol\MultiVendorMarketplace\Setup\InstallData::VENDOR_ENTITY, 'logo', 'frontend_input', 'media_image');
        // echo 'logo input done';
        $vendorSetup->updateAttribute(\Vinsol\MultiVendorMarketplace\Setup\InstallData::VENDOR_ENTITY, 'banner', 'backend_type', 'varchar');
        // echo 'banner label done';
        // $vendorSetup->updateAttribute(\Vinsol\MultiVendorMarketplace\Setup\InstallData::VENDOR_ENTITY, 'banner', 'frontend_input', 'media_image');
        // echo 'banner input done';
          
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