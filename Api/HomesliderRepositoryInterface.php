<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * CMS homeslider CRUD interface.
 * @api
 */
interface HomesliderRepositoryInterface
{
    /**
     * Save homeslider.
     *
     * @param \Ktpl\Homeslider\Api\Data\HomesliderInterface $homeslider
     * @return \Ktpl\Homeslider\Api\Data\HomesliderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\HomesliderInterface $homeslider);

    /**
     * Retrieve homeslider.
     *
     * @param int $homesliderId
     * @return \Ktpl\Homeslider\Api\Data\HomesliderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($homesliderId);

    /**
     * Retrieve homesliders matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Ktpl\Homeslider\Api\Data\HomesliderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete homeslider.
     *
     * @param \Ktpl\Homeslider\Api\Data\HomesliderInterface $homeslider
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\HomesliderInterface $homeslider);

    /**
     * Delete homeslider by ID.
     *
     * @param int $homesliderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($homesliderId);
}
