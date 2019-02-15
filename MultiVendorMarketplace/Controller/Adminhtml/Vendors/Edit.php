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
  protected $user;
  protected $role;

  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    \Magento\Backend\Model\Session $session,
    \Magento\Framework\Message\Manager $messageManager,
    \Magento\User\Model\UserFactory $userFactory,
    \Magento\Authorization\Model\RoleFactory $roleFactory,
    \Magento\Framework\Registry $registry
  )
  {
    $this->resultPageFactory = $resultPageFactory;
    $this->vendor = $vendorFactory->create();
    $this->user = $userFactory->create();
    $this->role = $roleFactory->create();
    $this->_coreRegistry = $registry;
    $this->session = $session;
    $this->messageManager = $messageManager;
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

    if ($id) {
      $this->vendor->load($id);
      $this->user->load($this->vendor->getUserId());
      $this->role->load($this->user->getId(), 'user_id');
      $msg = implode(', ',$this->vendor->getData());
      if (!$this->vendor->getId()) {
        $this->_redirect('*/*/');
      }
    }

    $data = $this->session->getFormData(true);

    // if (empty($data)) {
      $data = array_merge($this->vendor->getData(), $this->user->getData());
      $data['password'] = '';
      $data['role_id'] = $this->role->getParentId();
      $this->vendor->setData($data);
    // }
    $this->_coreRegistry->register('vendor', $this->vendor);
    $this->_setPageData();
    return $this->resultPage;
  }

  protected function _setPageData()
  {
    $resultPage = $this->getResultPage();
    if ($this->getRequest()->getParam('id')) {
      $resultPage->getConfig()->getTitle()->prepend(__('Edit Vendor'));
    } else {
      $resultPage->getConfig()->getTitle()->prepend(__('Add Vendor'));
    }
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