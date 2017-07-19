<?php
namespace Ktpl\Homeslider\Block;
use Ktpl\Homeslider\Model\ResourceModel\Homeslider\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Homeslider extends \Magento\Framework\View\Element\Template
{
    protected $_modelHomeslider;

    public function __construct(Context $context, 
            CollectionFactory $HomesliderList, 
            array $data = [])
        {
            $this->_modelHomeslider = $HomesliderList;
           parent::__construct($context, $data);
        }

   public function getHomesliderList()
   {
      $homesliderCollection = $this->_modelHomeslider->create();     
       return $homesliderCollection;
   }
}