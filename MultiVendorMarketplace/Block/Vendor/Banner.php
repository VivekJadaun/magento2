<?php
namespace Vinsol\MultiVendorMarketplace\Block\Vendor;

use Vinsol\MultiVendorMarketplace\Model\ResourceModel\Product\CollectionFactory;

class Banner extends \Magento\Framework\View\Element\Template
{
  public $_template = 'Vinsol_MultiVendorMarketplace::banner.phtml';
  public $banner = '';
  public $username = '' ;
  protected $adminActionContext;
  protected $session;
  protected $vendor;
  protected $response;
  protected $vendorId;

  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Framework\App\ResponseInterface $response,
    \Magento\Backend\App\Action\Context $adminActionContext,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    \Magento\User\Model\UserFactory $userFactory,
    array $data = []
  )
  {
    $this->adminActionContext = $adminActionContext;
    $this->vendor = $vendorFactory->create();
    $this->user = $userFactory->create();
    $this->response = $response;
    parent::__construct($context, $data);
  }

  public function getImageUrl()
  {
    // return $this->getMediaDirectory()->getAbsolutePath("marketplace/$this->vendorId/$this->banner");
    return $this->getUrl("pub/media/marketplace/") . $this->username . '/' . $this->banner;
  }

  public function _prepareLayout()
  {
    parent::_prepareLayout();
    $this->vendorId = $this->adminActionContext->getRequest()->getParam('id');
    if ($this->vendorId) {
      $this->vendor->load($this->vendorId);
      if ($this->vendor->getId()) {
        $this->user->load($this->vendor->getUserId());
        $this->username = $this->user->getUsername();
        if ($this->vendor->getBanner()) {
          $this->banner = $this->vendor->getBanner(); 
        }

      }

    }

  }

  public function getLocation()
  {
    return $this->getMediaDirectory();
  }

}