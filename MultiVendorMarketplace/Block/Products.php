<?php
namespace Vinsol\MultiVendorMarketplace\Block;

use Magento\Framework\Data\Helper\PostHelper;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Url\Helper\Data;
use Vinsol\MultiVendorMarketplace\Model\Product\ProductList\Layer as VendorLayer;

class Products extends \Magento\Catalog\Block\Product\ListProduct
{
  public $_template = 'Magento_Catalog::product/list.phtml';
  protected $request;
  protected $productCollection;
  protected $vendorLayer;
  protected $vendor;

  public function __construct(
    \Magento\Catalog\Block\Product\Context $context,
    \Magento\Framework\App\Action\Context $appContext,
    \Vinsol\MultiVendorMarketplace\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    PostHelper $postDataHelper,
    Resolver $layerResolver,
    CategoryRepositoryInterface $categoryRepository,
    Data $urlHelper,
    // VendorLayer $vendorLayer,
    array $data = []
  )
  {
    $this->request= $appContext->getRequest();
    $this->vendor = $vendorFactory->create();
    // $this->vendorLayer = $vendorLayer;
    $this->productCollection = $productCollectionFactory->create();
    parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
  }

  protected function _getProductCollection()
  {
    $vendorId = $this->request->getParam('id');
    if ($vendorId) {
      $this->vendor->load($vendorId);
      $collection = $this->productCollection->addAttributeToFilter('user_id', $this->vendor->getUserId());
      return $collection;
    } 
  }

  // public function getLayer()
  // {
  //   return $this->vendorLayer;      
  // }

}