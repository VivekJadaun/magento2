<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Order\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Psr\Log\LoggerInterface as Logger;
use Magento\Backend\Model\Auth;
use Magento\Framework\App\State;

class Collection extends \Magento\Sales\Model\ResourceModel\Order\Grid\Collection
{
    const VENDOR_ROLE_GROUP = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME;
    const JOIN_TABLE = \Vinsol\MultiVendorMarketplace\Model\VendorOrder::VENDOR_ORDER_TABLE;

    protected $authUser;

    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        State $appState,
        Auth $authUser
    )
    {
        $this->authUser = $authUser;
        $this->appState = $appState;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager);
    }

    public function _initSelect()
    {
        parent::_initSelect();

        $currentUser = $this->authUser->getUser();

        if ($this->appState->getAreaCode() == 'adminhtml') {
            if (($currentUser->getRole()->getRoleName() == self::VENDOR_ROLE_GROUP) && $currentUser->getIsActive()) {
                $currentUserId = $currentUser->getId();
                $this->getSelect()->join(self::JOIN_TABLE, 'entity_id = order_id')->where("user_id = ?", $currentUserId);
            }
        }

        return $this;
    }
}