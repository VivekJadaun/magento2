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
    
        $productSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        // $attributeSet = $this->attributeSetFactory->create();
        // $data = [
        //   'attribute_set_name' => \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET,
        //   'entity_type_id' => 4,
        //   'sort_order' => 0,
        // ];
        // $attributeSet->setData($data)->validate();
        // $attributeSet->save();
        // $attributeSet->initFromSkeleton('Default');
        // $attributeSet->save();
        // $productSetup->setDefaultSetToEntityType(\Magento\Catalog\Model\Product::ENTITY, \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET); 

        $productSetup->addAttributeToSet(\Magento\Catalog\Model\Product::ENTITY, \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET, 90, \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID);


      }

      $setup->endSetup();
    }
  }