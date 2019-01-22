<?php

  namespace Vinsol\MultiVendorMarketplace\Setup;

  use \Magento\Framework\Setup\InstallDataInterface;
  use \Magento\Framework\Setup\ModuleContextInterface;
  use \Magento\Framework\Setup\ModuleDataSetupInterface;
  use Magento\Authorization\Model\Acl\Role\Group as RoleGroup;
  use Magento\Authorization\Model\UserContextInterface;
  use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


  class InstallData implements InstallDataInterface
  {
    const USER_ID = 'user_id';
    const ATTRIBUTE_SET = 'Vendor';
    const VENDOR_ENTITY = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY;
    protected $vendorSetupFactory;
    protected $vendorSetup;
    protected $categorySetupFactory;
    protected $productSetup;
    protected $attributeSet;
    protected $rules;
    protected $role;

    public function __construct(
      \Vinsol\MultiVendorMarketplace\Setup\VendorSetupFactory $vendorSetupFactory,
      \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory,
      \Magento\Authorization\Model\RoleFactory $roleFactory,
      \Magento\Authorization\Model\RulesFactory $rulesFactory,
      AttributeSetFactory $attributeSetFactory
    )
    {
      $this->role = $roleFactory->create();
      $this->rules = $rulesFactory->create();  
      $this->attributeSet = $attributeSetFactory->create();
      $this->categorySetupFactory = $categorySetupFactory;  
      $this->vendorSetupFactory = $vendorSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
      $setup->startSetup();

      $this->productSetup = $this->categorySetupFactory->create(['setup' => $setup]);

      // $this->createNewRole()->assignRules();  //ADD CONDITION TO CHECK PREVIOUS EXISTENCE

      // $this->createNewAttributeSet()->createNewAttribute();  //ADD CONDITION TO CHECK PREVIOUS EXISTENCE

      $vendorEntity = self::VENDOR_ENTITY;
      $this->vendorSetup = $this->vendorSetupFactory->create(['setup' => $setup]);
      $this->vendorSetup->installEntities()
                        ->addAttribute($vendorEntity, 'contact_no', [
                          'type' => 'varchar',
                          'backend' => '',
                          'frontend' => '',
                          'label' => 'Contact No',
                          'input' => 'text',
                          'class' => '',
                          'source' => '',
                          'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                          'visible' => true,
                          'required' => true,
                          'user_defined' => true,
                          // 'group' => '',
                          'default' => '',
                          'searchable' => true,
                          'filterable' => true,
                          'comparable' => false,
                          'visible_on_front' => true,
                          'used_in_product_listing' => true,
                          'unique' => false
                        ])
                        ->addAttribute($vendorEntity, 'address', [
                          'type' => 'text',
                          'backend' => '',
                          'frontend' => '',
                          'label' => 'Address',
                          'input' => 'text',
                          'class' => '',
                          'source' => '',
                          'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                          'visible' => true,
                          'required' => true,
                          'user_defined' => true,
                          // 'group' => '',
                          'default' => '',
                          'searchable' => true,
                          'filterable' => true,
                          'comparable' => false,
                          'visible_on_front' => true,
                          'used_in_product_listing' => true,
                          'unique' => false
                        ])
                        ->addAttribute($vendorEntity, 'logo', [
                          'type' => 'text',
                          'backend' => '',
                          'frontend' => '',
                          'label' => 'Logo',
                          'input' => 'media_image',
                          'class' => '',
                          'source' => '',
                          'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                          'visible' => true,
                          'required' => true,
                          'user_defined' => true,
                          // 'group' => '',
                          'default' => '',
                          'searchable' => true,
                          'filterable' => true,
                          'comparable' => false,
                          'visible_on_front' => true,
                          'used_in_product_listing' => true,
                          'unique' => false
                        ])
                        ->addAttribute($vendorEntity, 'banner', [
                          'type' => 'text',
                          'backend' => '',
                          'frontend' => '',
                          'label' => 'Banner',
                          'input' => 'media_image',
                          'class' => '',
                          'source' => '',
                          'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                          'visible' => true,
                          'required' => true,
                          'user_defined' => true,
                          // 'group' => '',
                          'default' => '',
                          'searchable' => true,
                          'filterable' => true,
                          'comparable' => false,
                          'visible_on_front' => true,
                          'used_in_product_listing' => false,
                          'unique' => false
                        ]);
      
      $setup->endSetup();
    }


    public function createNewRole()
    {
      // $role = $this->roleFactory->create();
      $this->role->setName(\Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME)
          ->setPid(0)
          ->setRoleType(RoleGroup::ROLE_TYPE)
          ->setUserType(UserContextInterface::USER_TYPE_GUEST)
          ->save();

      return $this;

     }

     public function assignRules()
     {
      // $permitted_resources = ['Magento_Backend::dashboard', 'Magento_Catalog::products', 'Magento_Sales::sales', 'Magento_Customer::customer', 'Magento_Backend::myaccount'];
      $permitted_resources = [
        'Magento_Backend::dashboard', 
        'Vinsol_MultiVendorMarketplace::vendors',
        'Vinsol_MultiVendorMarketplace::vendors_label',
        'Vinsol_MultiVendorMarketplace::vendors_products',
        'Magento_Catalog::products'
      ];
      $this->rules->setRoleId($this->role->getId())
                  ->setResources($permitted_resources)
                  ->saveRel();

      return $this;
     }

     public function createNewAttributeSet()
     {
        $productTypeId = $this->productSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $this->productSetup->getDefaultAttributeSetId($productTypeId);
        $data = [
          'attribute_set_name' => self::ATTRIBUTE_SET,
          'entity_type_id' => $productTypeId,
          'sort_order' => 2,
        ];
        $this->attributeSet->setData($data)->validate();
        $this->attributeSet->save();
        return $this;
     }

     public function createNewAttribute()
     {
        $this->productSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, self::USER_ID, 
          [
            'type' => 'text',
            'backend' => '',
            'frontend' => '',
            'label' => 'Vendor',
            'input' => 'select',
            'class' => '',
            'source' => 'Vinsol\MultiVendorMarketplace\Model\Config\Source\Vendors',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => true,
            'user_defined' => true,
            // 'group' => '',
            'default' => '',
            'searchable' => true,
            'filterable' => true,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'unique' => false
            // 'attribute_set' => self::ATTRIBUTE_SET
          ]
        )
        ->addAttributeToSet(\Magento\Catalog\Model\Product::ENTITY, self::ATTRIBUTE_SET, 'General', self::USER_ID);
        return $this;
     }
  }