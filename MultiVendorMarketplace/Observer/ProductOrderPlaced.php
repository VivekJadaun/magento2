<?php
namespace Vinsol\MultiVendorMarketplace\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\OrderFactory;

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
	protected $productRepository;
  
	function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\App\Response\RedirectInterface $redirect,
		\Magento\Framework\App\ResponseInterface $response,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\Framework\UrlInterface $url,
		\Vinsol\MultiVendorMarketplace\Helper\Email $emailHelper,
    		\Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
		OrderFactory $orderFactory
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
  }

	public function execute(Observer $observer)
	{
		// $order = $this->order->loadByIncrementId($observer->getData('order_ids'));

		$order = $observer->getEvent()->getOrder();
		// $order = $this->order->load($orderId);


		$itemsCollection = $order->getItemsCollection();

		// var_dump($this->groupItemsByVendors($itemsCollection));
		$vendorsArray = $this->groupItemsByVendors($itemsCollection);

		foreach ($vendorsArray as $userId => $items) {
			// $this->emailHelper->sendOrderPlacedEmail($userId, $order->getId(), $productNames, $order->getCustomerName(), $order->getCustomerEmail());
			$this->emailHelper->sendOrderPlacedEmail($userId, $items);
		}	

	}

	public function groupItemsByVendors($itemsCollection)
	{
		$vendorsArray = array();

		foreach ($itemsCollection as $item) {
			$product = $this->productRepository->getById($item->getProductId());
			if ($product->hasData(self::USER_ID)) {
				if (array_key_exists($product->getUserId(), $vendorsArray)) {
					array_push($vendorsArray[$product->getUserId()], $item);
				} else {
					$vendorsArray[$product->getUserId()] = [$item];
				}
			}
		}

		return $vendorsArray;
	}

}