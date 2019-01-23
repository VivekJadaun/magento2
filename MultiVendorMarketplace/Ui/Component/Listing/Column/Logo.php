<?php
namespace Vinsol\MultiVendorMarketplace\Ui\Component\Listing\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Logo extends \Magento\Ui\Component\Listing\Columns\Column
{
  const ALT_FIELD = 'Vendor logo';
  
  protected $urlBuilder;
  protected $imageHelper;

  public function __construct(
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    Image $imageHelper,
    UrlInterface $urlBuilder,
    array $components = [],
    array $data = []
  ) {
    $this->vendor = $vendorFactory->create();
    $this->imageHelper = $imageHelper;
    $this->urlBuilder = $urlBuilder;
    parent::__construct($context, $uiComponentFactory, $components, $data);
  }

  public function prepareDataSource(array $dataSource)
  {
    if (isset($dataSource['data']['items'])) {
      foreach ($dataSource['data']['items'] as & $item) {
        if(isset($item['logo'])) {

          // $vendor = new \Magento\Framework\DataObject($item);
          $fileName = $item['logo'];
          // $path = 'media/images/';
          // $logo = $path.$name;
          // $vendor[$name.'_src'] = $logo;
          // $vendor[$name.'_alt'] = "Vendor logo.";
          // $item['logo'] = $vendor;

          $url = $this->urlBuilder->getUrl(UrlInterface::URL_TYPE_MEDIA).'/images/'.$fileName;
          $item[$fileName . '_src'] = $url;
          $item[$fileName . '_alt'] = $this->getAlt($item) ?: '';
          $item[$fileName.'_orig_src'] = $url;


        }
      }
    }

    return $dataSource;
  }

  protected function getAlt($row)
  {
      $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
      return isset($row[$altField]) ? $row[$altField] : null;
  }
}