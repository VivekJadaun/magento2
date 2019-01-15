<?php

namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Products;

class Index extends \Magento\Backend\App\Action
{
  protected $resultPageFactory;
  protected $resultPage;
  protected $vendor;

  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory
  )
  {
    $this->resultPageFactory = $resultPageFactory;
    $this->vendor = $vendorFactory->create();
    parent::__construct($context);
  }

  public function execute()
  {
    $this->_setPageData();
    return $this->getResultPage();
  }

  protected function _isAllowed()
  {
    return $this->_authorization->isAllowed('Vinsol_MultiVendorMarketplace::vendors');
  }

  protected function _setPageData()
  {
    $resultPage = $this->getResultPage();
    $resultPage->setActiveMenu('Vinsol_MultiVendorMarketplace::vendors');
    $resultPage->getConfig()->getTitle()->prepend(__('Marketplace Products'));
    return $this;
  }

  protected function getResultPage()
  {
    if (is_null($this->resultPage)) {
      $this->resultPage = $this->resultPageFactory->create();
    }
    return $this->resultPage;
  }
}