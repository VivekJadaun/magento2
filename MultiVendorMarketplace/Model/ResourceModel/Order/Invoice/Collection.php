<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Order\Invoice;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Psr\Log\LoggerInterface as Logger;
use Magento\Backend\Model\Auth;
use Magento\Framework\App\State;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot;

class Collection extends \Magento\Sales\Model\ResourceModel\Order\Invoice\Collection
{
    const VENDOR_ROLE_GROUP = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME;
    const JOIN_TABLE = \Vinsol\MultiVendorMarketplace\Model\VendorInvoice::VENDOR_INVOICE_TABLE;

    protected $authUser;
    protected $appState;

    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        Snapshot $entitySnapshot,
        // \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        // \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null,
        State $appState,
        Auth $authUser
    )
    {
        $this->authUser = $authUser;
        $this->appState = $appState;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $entitySnapshot);
    }

    public function _initSelect()
    {
        parent::_initSelect();

        if ($this->appState->getAreaCode() == 'adminhtml') {
            $currentUser = $this->authUser->getUser();
            if (($currentUser->getRole()->getRoleName() == self::VENDOR_ROLE_GROUP) && $currentUser->getIsActive()) {
                $currentUserId = $currentUser->getId();
                $this->getSelect()->join(self::JOIN_TABLE, 'entity_id = invoice_id')->where("user_id = ?", $currentUserId);
            }
        }

        return $this;
    }
}