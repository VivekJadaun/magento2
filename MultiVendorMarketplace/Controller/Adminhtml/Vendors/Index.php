<?php

namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Vendors;

class Index extends \Magento\Backend\App\Action
{
  protected $resultPageFactory;
  protected $resultPage;

  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory
  )
  {
    $this->resultPageFactory = $resultPageFactory;
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
    $resultPage->getConfig()->getTitle()->prepend(__('Vendors'));
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