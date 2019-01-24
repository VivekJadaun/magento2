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
    
        //THIS FILE IS NOT NEEDED IN THE END;

        // $productSetup = $this->eavSetupFactory->create(['setup' => $setup]);
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
        // $attributeSet->initFromSkeleton($attributeSetId);
        // $attributeSet->save();
        // $productSetup->setDefaultSetToEntityType(\Magento\Catalog\Model\Product::ENTITY, \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET); 

        // $productSetup->updateAttribute(\Magento\Catalog\Model\Product::ENTITY, self::USER_ID, 'attribute_set', \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET); 

        // $productSetup->addAttributeToSet(\Magento\Catalog\Model\Product::ENTITY, \Vinsol\MultiVendorMarketplace\Setup\InstallData::ATTRIBUTE_SET, 'general', \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID, 8);

        echo 'upgraded';

      }

      $setup->endSetup();
    }
  }