<?php
namespace Vinsol\MultiVendorMarketplace\Block\Vendor;

class Logo extends \Magento\Framework\View\Element\Template
{
  public $_template = 'Vinsol_MultiVendorMarketplace::logo.phtml';
  public $logo = '';
  public $username = '';
  protected $adminActionContext;
  protected $session;
  protected $vendor;
  protected $user;
  protected $vendorCollection;
  protected $response;
  protected $vendorId;

  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Framework\App\ResponseInterface $response,
    \Magento\Backend\App\Action\Context $adminActionContext,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    // \Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor\CollectionFactory $vendorCollection,
    \Magento\User\Model\UserFactory $userFactory,
    array $data = []
  )
  {
    $this->adminActionContext = $adminActionContext;
    $this->vendor = $vendorFactory->create();
    $this->user = $userFactory->create();
    // $this->vendorCollection = $vendorCollection->create();
    $this->response = $response;
    parent::__construct($context, $data);
  }

  public function getImageUrl()
  {
    // return $this->getMediaDirectory()->getAbsolutePath("marketplace/$this->vendorId/$this->logo");
    return $this->getUrl("pub/media/marketplace/") . $this->username . '/' . $this->logo;
  }

  public function _prepareLayout()
  {
    parent::_prepareLayout();
    $this->vendorId = $this->adminActionContext->getRequest()->getParam('id');
    if ($this->vendorId) {
      $this->vendor->load($this->vendorId);
      // $this->vendorCollection->addAttributeToFilter('entity_id', $this->vendorId)->load();
      // var_dump($this->vendor->getData());

      // $userId = $this->vendor->getUserId();
      // $this->user->load($userId);
      if ($this->vendor->getId()) {
        $this->user->load($this->vendor->getUserId());
        $this->username = $this->user->getUsername();
        if ($this->vendor->getLogo()) {
          $this->logo = $this->vendor->getLogo(); 
        }

      }

      // if (count($this->vendorCollection->getData())) {
      //   $this->username = $this->vendorCollection->getData()[0]['username'];
      //   if ($this->vendorCollection->getData()[0]['logo']) {
      //     $this->logo = $this->vendorCollection->getData()[0]['logo']; 
      //   }

      // }
    }

  }
}