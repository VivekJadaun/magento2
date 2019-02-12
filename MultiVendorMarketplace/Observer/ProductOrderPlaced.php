<?php
namespace Vinsol\MultiVendorMarketplace\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\OrderFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
// use Vinsol\MultiVendorMarketplace\Model\VendorOrderFactory;
use Magento\Framework\App\ResourceConnection;
// use Vinsol\MultiVendorMarketplace\Model\ResourceModel\VendorOrder\CollectionFactory as VendorOrderCollectionFactory;

class ProductOrderPlaced implements ObserverInterface
{
	const USER_ID = \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID;

	protected $context;
	protected $redirect;
	protected $response;
	protected $messageManager;
	protected $url;
	protected $emailHelper;
	protected $order;
	// protected $vendorOrder;
	protected $productRepository;
	protected $resourceConnection;
  
	function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\App\Response\RedirectInterface $redirect,
		\Magento\Framework\App\ResponseInterface $response,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\Framework\UrlInterface $url,
		\Vinsol\MultiVendorMarketplace\Helper\Email $emailHelper,
		ProductRepositoryInterface $productRepositoryInterface,
		OrderFactory $orderFactory,
		// VendorOrderFactory $vendorOrderFactory,
		ResourceConnection $resourceConnection
	)
	{
		$this->context = $context;
		$this->redirect = $redirect;
		$this->response = $response;
		$this->messageManager = $messageManager;
		$this->url = $url;
		$this->emailHelper = $emailHelper;
		$this->order = $orderFactory->create();
    	$this->productRepository = $productRepositoryInterface;
		// $this->vendorOrder = $vendorOrderFactory->create();
    	$this->resourceConnection = $resourceConnection;

  }

	public function execute(Observer $observer)
	{
		// $order = $this->order->loadByIncrementId($observer->getData('order_ids'));

		$order = $observer->getEvent()->getOrder();
		// $order = $this->order->load($orderId);


		$itemsCollection = $order->getItemsCollection();

		// var_dump($this->groupItemsByVendors($itemsCollection));
		$vendorItemsGroup = $this->groupItemsByVendors($itemsCollection);

		$vendorOrders = array();

		foreach ($vendorItemsGroup as $userId => $items) {
			// $this->emailHelper->sendOrderPlacedEmail($userId, $order->getId(), $productNames, $order->getCustomerName(), $order->getCustomerEmail());
			array_push($vendorOrders, ['order_id' => $order->getId(), 'vendor_id' => null, 'user_id' => $userId]);
			$this->emailHelper->sendOrderPlacedEmail($userId, $items);
			// $this->createNewVendorOrder($order->getId(), $userId);
		}	

		$this->insertMultiple(\Vinsol\MultiVendorMarketplace\Model\VendorOrder::VENDOR_ORDER_TABLE, $vendorOrders);
		// $this->vendorOrder->getConnection()->insertMultiple(\Vinsol\MultiVendorMarketplace\Model\VendorOrder::VENDOR_ORDER_TABLE, $vendorOrders);
	}

	public function groupItemsByVendors($itemsCollection)
	{
		$vendorItemsGroup = array();

		foreach ($itemsCollection as $item) {
			$product = $this->productRepository->getById($item->getProductId());
			if ($product->hasData(self::USER_ID)) {
				if (array_key_exists($product->getUserId(), $vendorItemsGroup)) {
					array_push($vendorItemsGroup[$product->getUserId()], $item);
				} else {
					$vendorItemsGroup[$product->getUserId()] = [$item];
				}
			}
		}

		return $vendorItemsGroup;
	}

	// public function createNewVendorOrder($orderId, $userId, $vendorId = null)
	// {
	// 	$this->vendorOrder->setData([
	// 		'order_id' => $orderId,
	// 		'vendor_id' => $vendorId,
	// 		'user_id' => $userId
	// 	]);

	// 	$this->vendorOrder->save();
	// }

	public function insertMultiple($tableName, array $rows)
	{
		try {
			$tableName = $this->resourceConnection->getTableName($tableName);
			$this->resourceConnection->getConnection()->insertMultiple($tableName, $rows);
		} catch (\Exception $e) {
			$this->messageManager->addException($e);
		}
		
		return $this;
	}
}