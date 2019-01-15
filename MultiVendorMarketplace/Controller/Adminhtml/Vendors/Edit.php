<?php
namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Vendors;

class Edit extends \Magento\Backend\App\Action
{
  protected $_coreRegistry = null;
  protected $resultPageFactory;
  protected $resultPage;
  protected $vendor;
  protected $session;
  protected $messageManager;
  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    \Magento\Backend\Model\Session $session,
    \Magento\Framework\Message\Manager $messageManager,
    \Magento\Framework\Registry $registry
  )
  {
    $this->resultPageFactory = $resultPageFactory;
    $this->vendor = $vendorFactory->create();
    $this->_coreRegistry = $registry;
    $this->session = $session;
    $this->messageManager = $messageManager;
    parent::__construct($context);
  }
  
  protected function _isAllowed()
  {
    return $this->_authorization->isAllowed('Vinsol_MultiVendorMarketplace::vendors');
  }

  public function execute()
  {
    $id = $this->getRequest()->getParam('id');
    $var = implode(', ', $this->getRequest()->getParams());
    $this->messageManager->addSuccess("vendor $id , params: $var");

    if ($id) {
      $this->vendor->load($id);
      // $this->vendor->getCollection()->addAttributeToFilter('entity_id', $id)->load();
      $msg = implode(', ',$this->vendor->getData());
      $this->messageManager->addSuccess("$msg");
      // $this->vendor->getCollection()->addAttributeToFilter('entity_id', $id)->load();
      // $obj = $this->vendor->getCollection()->addAttributeToFilter('entity_id', $id)->load()->getData();
      // $Data = implode(', ', $this->vendor->getData());
      // if (!$Data['entity_id']) {
    // $this->messageManager->addSuccess("$Data");

      // if (!$this->vendor->getData('entity_id')) {
      if (!$this->vendor->getId()) {
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
    // $resultPage->setActiveMenu('Vinsol_MultiVendorMarketplace::vendors');
    $resultPage->getConfig()->getTitle()->prepend(__('Edit Vendor'));
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