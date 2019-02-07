<?php
namespace Vinsol\MultiVendorMarketplace\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
// use Magento\Framework\Mail\Template\TransportBuilder;
use Vinsol\MultiVendorMarketplace\Model\Mail\TransportBuilder;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Item;
use Magento\User\Model\UserFactory;
use Magento\Framework\App\Area;
use Magento\Store\Model\Store;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Message\ManagerInterface;


class Email extends AbstractHelper
{
	const EMAIL_SUBJECT = 'Your product(s) just got purchased!';

	protected $escaper;
	protected $transportBuilder;
	protected $user;
	protected $logger;
	protected $messageManager;

	public function __construct(
		Context $context,
		Escaper $escaper,
		TransportBuilder $transportBuilder,
		UserFactory $userFactory,
	    Filesystem $fileSystem,
	    ManagerInterface $messageManager
	)
	{
		parent::__construct($context);
		$this->escaper = $escaper;
		$this->logger = $context->getLogger();
		$this->transportBuilder = $transportBuilder;
		$this->user = $userFactory->create();
	    $this->fileSystem = $fileSystem;
	    $this->messageManager = $messageManager;
	}

	// public function sendOrderPlacedEmail($userId, $orderId, $productNames = array(), $customerName, $customerEmail)
	public function sendOrderPlacedEmail($userId, $items)
	{
		// $path = $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('catalog');

		// foreach ($sameVendorItems as $userId => $productNames) {

		// $userId = array_keys($sameVendorItems)[0];
		// $productNames = array_values($sameVendorItems)[0];

		$this->user->load($userId);

		$order = $items[0]->getOrder();
		$orderId = $order->getIncrementId();

		$customerName = $order->getCustomerName();
		$customerEmail = $order->getCustomerEmail();

		$productNames = [];
		// $productQty = [];

		// $products = array();

		foreach ($items as $item) {
			array_push($productNames, $item->getName() . " (qty: " . $item->getQtyOrdered() . ")");
			// array_push($products, ['name' => $item->getName(), 'qty' => $item->getQtyOrdered()]);
			// array_push($products, $item);
		}

		$vendorName = $this->user->getName();

			
		try {
			// $sender = [
			// 	// 'name' => $this->escaper->escapeHtml(self::EMAIL_SUBJECT),
			// 	// 'email' =>	$this->escaper->escapeHtml($this->user->getEmail())
			// 	'name' => self::EMAIL_SUBJECT,
			// 	'email' =>	$this->user->getEmail()
			// ];

			$templateVariables = [
				'customerName' => $customerName,
				'customerEmail' => $customerEmail,
				'productNames' => implode(', ', $productNames),
				// 'products' => $products,
				'orderId' => $orderId,
				'vendorName' => $vendorName
			];
			
			$this->transportBuilder
            	->clearFrom()
            	->clearSubject()
            	->clearMessageId()
            	->clearBody()
            	->clearRecipients()
				->setTemplateIdentifier('marketplace_email_template')
				->setTemplateOptions([
					'area' => Area::AREA_ADMINHTML,
  					'store' => Store::DEFAULT_STORE_ID
				])
				->setTemplateVars($templateVariables)
				->setFrom('general')
				->addTo($this->user->getEmail(), $this->user->getFirstname());
				// ->addAttachment($filePath, $fileName)

			$this->transportBuilder->getTransport()->sendMessage();

		} catch (\Exception $e) {
			$this->messageManager->addException($e);
			$this->logger->debug($e->getMessage());
		}

		// }

		// $filePath = $item->getProduct()->getImage();
		// $image = array_slice((explode('/', $filePath)), -1)[0];
		// $filePath = str_replace($image, '', $filePath);

		// $filePath = $path + $filePath;
		// $fileName = $image;

		// // $this->messageManager->addSuccess(http_build_query([$filePath, $fileName]));

		// $this->logger->debug("Filename -> $fileName");
		// $this->logger->debug("Filepath -> $filePath");
		
		// 
	}


	// public function sendMail()
 //  {
 //    $this->transportBuilder->setTemplateIdentifier('marketplace_email_template')->setTemplateOptions(['area' => Area::AREA_ADMINHTML, 'store' => Store::DEFAULT_STORE_ID ])->setTemplateVars(['name' => 'Vivek Jadaun'])->setFrom('general')->addTo('vivek@vinsol.com', 'Vivek');
 //    $this->transportBuilder->getTransport()->sendMessage();
 //  }
}