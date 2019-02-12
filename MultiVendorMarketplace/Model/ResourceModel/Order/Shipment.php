<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Order;

use Magento\Framework\Model\ResourceModel\Db\VersionControl\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\RelationComposite;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot;
use Magento\SalesSequence\Model\Manager;
use Magento\Sales\Model\EntityInterface;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Sales\Model\ResourceModel\Attribute;
use Magento\Backend\Model\Auth;
use Magento\Framework\App\State;


class Shipment extends \Magento\Sales\Model\ResourceModel\Order\Shipment
{
    const VENDOR_ROLE_GROUP = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME;

    protected $vendorShipment;
    protected $authUser;
    protected $appState;

    function __construct(
        Context $context,
        Snapshot $entitySnapshot,
        RelationComposite $entityRelationComposite,
        Attribute $attribute,
        Manager $sequenceManager,
        $connectionName = null,
        \Vinsol\MultiVendorMarketplace\Model\VendorShipmentFactory $vendorShipmentFactory,
        State $appState,
        Auth $authUser
    )
    {
        $this->vendorShipment = $vendorShipmentFactory->create();
        $this->authUser = $authUser;
        $this->appState = $appState;
        parent::__construct($context, $entitySnapshot, $entityRelationComposite, $attribute, $sequenceManager, $connectionName);
    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($this->appState->getAreaCode() == 'adminhtml') {
            $currentUser = $this->authUser->getUser();
            
            if (($currentUser->getRole()->getRoleName() == self::VENDOR_ROLE_GROUP) && $currentUser->getIsActive()) {
                $currentUserId = $currentUser->getId();            
                $this->vendorShipment->setData([
                    'shipment_id' => $object->getId(),
                    'user_id' => $currentUserId
                ]);
                $this->vendorShipment->save();
            }
        }

        parent::_afterSave($object);
    }
}