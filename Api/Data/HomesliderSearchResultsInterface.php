<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for ktpl employee search results.
 * @api
 */
interface HomesliderSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get employees list.
     *
     * @return \Ktpl\Homeslider\Api\Data\HomesliderInterface[]
     */
    public function getItems();

    /**
     * Set employees list.
     *
     * @param \Ktpl\Homeslider\Api\Data\HomesliderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
