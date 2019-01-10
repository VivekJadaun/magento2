<?php 

namespace Vinsol\MultiVendorMarketplace\Block;

/**
 * 
 */
class VendorNames extends \Magento\Config\Block\System\Config\Form\Field
{
  protected $vendors;
  
  public function __construct(
    \Vinsol\MultiVendorMarketplace\Model\Config\Source\Vendors $vendors,
    \Magento\Backend\Block\Template\Context $context, 
    array $data = []
  )
  {
    $this->vendors = $vendors->toOptionArray();
    parent::__construct($context, $data);
  }

  protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
  {
    $value = $element->getData('value');

    if ($this->vendors->count() > 0) {
      // var_dump($this->vendors->count());
      $name = "[specific_settings][vendor_name][value]";
      $id = "vendor_name";

      $html = $this->getLayout()
                   ->createBlock('Magento\Framework\View\Element\Html\Select')
                   ->setName($name)
                   ->setId($id)
                   ->setTitle(__(""))
                   ->setValue($value)
                   ->setOptions($this->vendors)
                   ->setExtraParams('data-validate="{\'validate-select\':true}"')
                   ->getHtml();
    }

    else {
      $html = '<p>There is no option available.</p>';
      $html .= '<script type="text/javascript">
         require(["jquery"], function ($) {
              $(document).ready(function () {
                  $(".hidden").each(function(){
                      $(this).closest("tr").hide(); // Can also use .remove() to remove the field completely
                  })
              });
          });
      </script>';
    }

    return $html;
  }
}