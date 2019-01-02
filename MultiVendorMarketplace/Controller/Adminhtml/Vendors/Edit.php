<?php
namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Vendors;

class Edit extends \Magento\Backend\App\Action
{
  protected $_coreRegistry = null;
  protected $resultPageFactory;
  protected $resultPage;
  protected $vendor;
  protected $session;
  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    \Magento\Backend\Model\Session $session,
    \Magento\Framework\Registry $registry
  )
  {
    $this->resultPageFactory = $resultPageFactory;
    $this->vendor = $vendorFactory->create();
    $this->_coreRegistry = $registry;
    $this->session = $session;
    parent::__construct($context);
  }
  
  protected function _isAllowed()
  {
    return $this->_authorization->isAllowed('Vinsol_MultiVendorMarketplace::vendors');
  }

  public function execute()
  {
    $id = $this->getRequest()->getParam('id');
    if ($id) {
      $this->vendor->load($id);
      if (!$this->vendor->getEntityId()) {
        $this->_redirect('*/*/');
      }
    }
    
    $data = $this->session->getFormData(true);

    if (!empty($data)) {
      $this->vendor->setData($data);
    }
    $this->_coreRegistry->register('vendor', $this->vendor);
    $this->_setPageData();
    return $this->resultPage;
  }

  protected function _setPageData()
  {
    $resultPage = $this->getResultPage();
    $resultPage->setActiveMenu('Vinsol_MultiVendorMarketplace::vendors');
    $resultPage->getConfig()->getTitle()->prepend(__('Edit'));
    return $this;
  }

  protected function getResultPage()
  {
    if (is_null($this->resultPage)) {
      $this->resultPage = $this->resultPageFactory->create();
    }
    $this->resultPage->setActiveMenu('Vinsol_MultiVendorMarketplace::vendors');
    return $this->resultPage;
  }

}