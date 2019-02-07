<?php 
namespace Vinsol\MultiVendorMarketplace\Model\Mail;

/**
 * 
 */
class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
	
	public function clearFrom()
    {
        //$this->_from = null;
        $this->message->clearFrom('From');
        return $this;
    }
 
    public function clearSubject()
    {
        $this->message->clearSubject();
        return $this;
    }
 
    public function clearMessageId()
    {
        $this->message->clearMessageId();
        return $this;
    }
 
    public function clearBody()
    {
        $this->message->setParts([]);
        return $this;
    }
 
    public function clearRecipients()
    {
        $this->message->clearRecipients();
        return $this;
    }
}