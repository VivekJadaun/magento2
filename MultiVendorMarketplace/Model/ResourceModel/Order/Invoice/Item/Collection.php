<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Order\Invoice\Item;

use Magento\Backend\Model\Auth;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Framework\App\State;

class Collection extends \Magento\Sales\Model\ResourceModel\Order\Invoice\Item\Collection
{
    const CATALOG_PRODUCT = 'catalog_product';
    const VENDOR_ROLE_GROUP = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME;
    const JOIN_TABLE = \Vinsol\MultiVendorMarketplace\Model\ResourceModel\Order\Item\Collection::JOIN_TABLE;
    const ATTRIBUTE_CODE = \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID;

    protected $authUser;
    protected $appState;
    protected $productAttribute;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot $entitySnapshot,
        // \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        // \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null,
        Auth $authUser,
        Attribute $productAttribute,
        State $appState
    )
    {
        $this->authUser = $authUser;
        $this->appState = $appState;
        $this->productAttribute = $productAttribute;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $entitySnapshot, null, null);
    }

    public function _initSelect()
    {
        parent::_initSelect();

        // $attributeId = $this->productAttribute->loadByCode(self::CATALOG_PRODUCT, self::ATTRIBUTE_CODE)->getId();
        // $currentUser = $this->authUser->getUser();

        // if ($this->appState->getAreaCode() == 'adminhtml') {
        //     if (($currentUser->getRole()->getRoleName() == self::VENDOR_ROLE_GROUP) && $currentUser->getIsActive()) {
        //         $currentUserId = $currentUser->getId();
        //         $this->getSelect()
        //             ->join(self::JOIN_TABLE, 'product_id = ' . self::JOIN_TABLE . '.entity_id')
        //             ->where("attribute_id = ?", $attributeId)
        //             ->where("value = ?", $currentUserId);
        //     }
        // }

        // var_dump($this->getSelect()->__toString());
        return $this;
    }
}