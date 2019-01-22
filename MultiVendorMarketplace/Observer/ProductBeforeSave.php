<?php
  namespace Vinsol\MultiVendorMarketplace\Observer;

  use \Magento\Framework\Event\Observer;
  use \Magento\Framework\Event\ObserverInterface;
  /**
   * 
   */
  class ProductBeforeSave implements ObserverInterface
  {
    const ADMIN_ROLE_NAME = \Vinsol\MultiVendorMarketplace\Ui\DataProvider\Product\ProductDataProvider::ADMIN_ROLE_GROUP;
    protected $context;
    protected $redirect;
    protected $response;
    protected $messageManager;
    protected $url;
    public function __construct(
      \Magento\Backend\App\Action\Context $context,
      \Magento\Framework\App\Response\RedirectInterface $redirect,
      \Magento\Framework\App\ResponseInterface $response,
      \Magento\Framework\Message\ManagerInterface $messageManager,
      \Magento\Framework\UrlInterface $url
    )
    {
      $this->context = $context;
      $this->redirect = $redirect;
      $this->response = $response;
      $this->messageManager = $messageManager;
      $this->url = $url;
    }

    public function execute(Observer $observer)
    {
      $productOwnerId = $observer->getProduct()->getUserId();
      $productAttributeSet = $observer->getProduct()->getAttributeSet();
      $currentUserRole = $this->context->getAuth()->getUser()->getRole()->getRoleName();
      $currentUserId = $this->context->getAuth()->getUser()->getId();

      // var_dump($productOwnerId, $currentUserId, $currentUserRole, self::ADMIN_ROLE_NAME, $productAttributeSet);
      if (($currentUserRole != self::ADMIN_ROLE_NAME) && ($productAttributeSet != 'Vendor')) {
        if (($productOwnerId !=  $currentUserId) && ($currentUserRole != self::ADMIN_ROLE_NAME)) {
          throw new \Exception("Error Saving Product. Invalid Vendor Id");
          // $this->messageManager->addError(__('Product not saved!'));
          // $url = $this->url->getUrl('marketplace/products/');
          // $this->response->setRedirect($url)->sendResponse();
        }
      }

    }
  }
?>