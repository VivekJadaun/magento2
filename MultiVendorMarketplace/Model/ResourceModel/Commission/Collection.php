<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Commission;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor\Collection as VendorCollection;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
// use Magento\Framework\App\State;

class Collection extends VendorCollection
{
    // const VENDOR_ENTITY = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY;
    const SALES_ORDER_ITEM = 'sales_order_item';
    const VENDOR_ORDER = \Vinsol\MultiVendorMarketplace\Model\VendorOrder::VENDOR_ORDER_TABLE;
    const CATALOG_PRODUCT = \Magento\Catalog\Model\Product::ENTITY;
    const CATALOG_PRODUCT_ENTITY = \Magento\Catalog\Model\Product::ENTITY . '_entity';
    const CATALOG_PRODUCT_ENTITY_TYPE = \Magento\Catalog\Model\Product::ENTITY . '_entity_text';
    const ATTRIBUTE_CODE = \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID;

    protected $productAttribute;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Eav\Model\EntityFactory $eavEntityFactory,
        \Magento\Eav\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Message\Manager $messageManager,
        \Magento\Authorization\Model\RoleFactory $roleFactory,
        Attribute $productAttribute
    )
    {
        $this->productAttribute = $productAttribute;
        parent::__construct(
            $entityFactory, 
            $logger, 
            $fetchStrategy, 
            $eventManager, 
            $eavConfig, 
            $resource, 
            $eavEntityFactory, 
            $resourceHelper, 
            $universalFactory,
            $connection, 
            $messageManager, 
            $roleFactory
        );
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        
        $attributeId = $this->productAttribute->loadByCode(self::CATALOG_PRODUCT, self::ATTRIBUTE_CODE)->getId();

        $this->getSelect()
            ->joinInner(
                ['secondTable' => $this->getTable(self::VENDOR_ORDER)],
                'e.user_id = secondTable.user_id',
                ['id', 'order_id']
            )->joinInner(
                ['thirdTable' => $this->getTable(self::SALES_ORDER_ITEM)],
                'secondTable.order_id = thirdTable.order_id',
                ['product_id', 'price', 'item_id']
            )->joinInner(
                ['fourthTable' => $this->getTable(self::CATALOG_PRODUCT_ENTITY)],
                'thirdTable.product_id = fourthTable.entity_id',
                ['sku']
            )->joinInner(
                ['fifthTable' => $this->getTable(self::CATALOG_PRODUCT_ENTITY_TYPE)],
                'fourthTable.entity_id = fifthTable.entity_id',
                ['value_id', 'attribute_id', 'store_id', 'value']
            )->where("fifthTable.attribute_id = ?", $attributeId);

        $this->messageManager->addSuccess($this->getSelect()->__toString());

        return $this;

    }
}