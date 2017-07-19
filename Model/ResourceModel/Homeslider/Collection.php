<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Model\ResourceModel\Homeslider;

use Ktpl\Homeslider\Api\Data\HomesliderInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * CMS Homeslider Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'homeslider_id';   

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ktpl\Homeslider\Model\Homeslider', 'Ktpl\Homeslider\Model\ResourceModel\Homeslider');        
    }
   
}
