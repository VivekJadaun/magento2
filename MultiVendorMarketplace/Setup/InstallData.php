<?php

  namespace Vinsol\MultiVendorMarketplace\Setup;

  use \Magento\Framework\Setup\InstallDataInterface;
  use \Magento\Framework\Setup\ModuleContextInterface;
  use \Magento\Framework\Setup\ModuleDataSetupInterface;
  use Magento\Authorization\Model\Acl\Role\Group as RoleGroup;
  use Magento\Authorization\Model\UserContextInterface;

  class InstallData implements InstallDataInterface
  {
    protected $vendorSetupFactory;
    protected $roleFactory;
    protected $rulesFactory;

    public function __construct(
      \Vinsol\MultiVendorMarketplace\Setup\VendorSetupFactory $vendorSetupFactory,
      \Magento\Authorization\Model\RoleFactory $roleFactory,
      \Magento\Authorization\Model\RulesFactory $rulesFactory
    )
    {
      $this->vendorSetupFactory = $vendorSetupFactory;
      $this->roleFactory =  $roleFactory;
      $this->rulesFactory = $rulesFactory;  
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
      $setup->startSetup();

      if (version_compare($context->getVersion(), '1.0.0', '<')) {
        $vendorEntity = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY;
        $vendorSetup = $this->vendorSetupFactory->create(['setup' => $setup]);

        $role = $this->roleFactory->create();
        $role->setName(\Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME)
             ->setPid(0)
             ->setRoleType(RoleGroup::ROLE_TYPE)
             ->setUserType(UserContextInterface::USER_TYPE_GUEST)
             ->save();

        // $permitted_resources = ['Magento_Backend::dashboard', 'Magento_Catalog::products', 'Magento_Sales::sales', 'Magento_Customer::customer', 'Magento_Backend::myaccount'];
        $permitted_resources = ['Magento_Backend::dashboard'];
        $this->rulesFactory->create()
             ->setRoleId($role->getId())
             ->setResources($permitted_resources)
             ->saveRel();

        $vendorSetup->installEntities();
        $vendorSetup->addAttribute($vendorEntity, 'contact_no', ['type' => 'varchar']);
        $vendorSetup->addAttribute($vendorEntity, 'address', ['type' => 'text']);
        $vendorSetup->addAttribute($vendorEntity, 'logo', ['type' => 'text']);
        $vendorSetup->addAttribute($vendorEntity, 'banner', ['type' => 'text']);
      
      }
      
      $setup->endSetup();
    }
  }