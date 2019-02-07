<?php
namespace Vinsol\MultiVendorMarketplace\Model\Sales;

class Order extends \Magento\Sales\Model\Order
{
	// const USER_ID = \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID;
	
	// public function place()
	// {
	// parent::place();

	// $itemCollection = $this->getItemsCollection();

	// foreach ($itemCollection as $item) {
	// 	if ($this->hasVendor($item)) {
	// 		$this->_eventManager->dispatch('order_item_has_vendor', ['item' => $item]);
	// 	}
	// }

	// return $this;
	// }

	// public function hasVendor($item)
	// {
	// 	return $item->hasData(self::USER_ID);
	// }
}