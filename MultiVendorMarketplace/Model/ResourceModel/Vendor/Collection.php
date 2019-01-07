<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor;

  class Collection extends \Magento\Eav\Model\Entity\Collection\AbstractCollection
  {

    const ADMIN_USER_VENDOR_ENTITY_FIELDS = array(
      '_user_id' => 'user_id',
      'firstname' => 'firstname', 
      'lastname' => 'lastname', 
      'email' => 'email', 
      'username' => 'username', 
      'created' => 'created', 
      'is_active' => 'is_active'
    );
    const ROLE_FIELDS = array(
      'role_id' => 'role_id', 
      'role_name' => 'role_name'
    );

    protected $mainTable = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY . '_entity';
    protected $adminUserTable = \Vinsol\MultiVendorMarketplace\Model\Vendor::ADMIN_USER;
    protected $roleTable = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_TABLE;
    protected $roleName = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME;

    protected $roleId;

    public function __construct(
      \Magento\Authorization\Model\RoleFactory $roleFactory,
      \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
      \Psr\Log\LoggerInterface $logger,
      \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
      \Magento\Framework\Event\ManagerInterface $eventManager,
      \Magento\Eav\Model\Config $eavConfig,
      \Magento\Framework\App\ResourceConnection $resource,
      \Magento\Eav\Model\EntityFactory $eavEntityFactory,
      \Magento\Eav\Model\ResourceModel\Helper $resourceHelper,
      \Magento\Framework\Validator\UniversalFactory $universalFactory,
      \Magento\Framework\DB\Adapter\AdapterInterface $connection = null
    ) 
    {
      // $this->roleId = $roleFactory->create()->getCollection()->addFieldToFilter('role_name', 'vendor')->setPageSize(1)->setCurPage(1)->getId();
      // $this->roleId = $roleFactory->create()->getCollection()->addFieldToFilter('role_name', 'vendor')->setCurPage(1)->setPageSize(1)->getData();
      // print_r($this->roleId);
      parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $eavConfig, $resource, $eavEntityFactory, $resourceHelper, $universalFactory, $connection);
    }
    
    protected function _construct()
    {
      $this->_init(
        'Vinsol\MultiVendorMarketplace\Model\Vendor', 
        'Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor'
      );

      // $this->roleId = $this->role->load('role_name', 'vendor')->setPageSize(1)->setCurrPage(1)->getId();  //ALTERNATIVELY SET UNIQUE CONSTRAINT ON 'role_name' IN 'authorization_role' 
    }

    // protected function _renderFiltersBefore ()
    // {
    //   $this->_initSelect();
    //   parent::_renderFiltersBefore();
    // }

    protected function _initSelect()
    {
      parent::_initSelect();

      $where = "role_name = '$this->roleName' OR parent_id = 17";
      $this->joinTable($this->adminUserTable, 'user_id=user_id', self::ADMIN_USER_VENDOR_ENTITY_FIELDS);
      $this->joinTable($this->roleTable, 'user_id=user_id', self::ROLE_FIELDS, $where, 'inner');

      $this->addFilterToMap('role_id', 'role_id');
      $this->addFilterToMap('role_name', 'role_name');      //SORTING & FILTERING DON'T WORK WITHOUT IT
      return $this;
    }
  }

