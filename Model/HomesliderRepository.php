<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Model;

use Ktpl\Homeslider\Api\Data;
use Ktpl\Homeslider\Api\HomesliderRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Ktpl\Homeslider\Model\ResourceModel\Homeslider as ResourceHomeslider;
use Ktpl\Homeslider\Model\ResourceModel\Homeslider\CollectionFactory as HomesliderCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class HomesliderRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class HomesliderRepository implements HomesliderRepositoryInterface
{
    /**
     * @var ResourceHomeslider
     */
    protected $resource;

    /**
     * @var HomesliderFactory
     */
    protected $homesliderFactory;

    /**
     * @var HomesliderCollectionFactory
     */
    protected $homesliderCollectionFactory;

    /**
     * @var Data\HomesliderSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Ktpl\Homeslider\Api\Data\HomesliderInterfaceFactory
     */
    protected $dataHomesliderFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param ResourceHomeslider $resource
     * @param HomesliderFactory $homesliderFactory
     * @param Data\HomesliderInterfaceFactory $dataHomesliderFactory
     * @param HomesliderCollectionFactory $homesliderCollectionFactory
     * @param Data\HomesliderSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceHomeslider $resource,
        HomesliderFactory $homesliderFactory,
        \Ktpl\Homeslider\Api\Data\HomesliderInterfaceFactory $dataHomesliderFactory,
        HomesliderCollectionFactory $homesliderCollectionFactory,
        Data\HomesliderSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->homesliderFactory = $homesliderFactory;
        $this->homesliderCollectionFactory = $homesliderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataHomesliderFactory = $dataHomesliderFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * Save Homeslider data
     *
     * @param \Ktpl\Homeslider\Api\Data\HomesliderInterface $homeslider
     * @return Homeslider
     * @throws CouldNotSaveException
     */
    public function save(Data\HomesliderInterface $homeslider)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $homeslider->setStoreId($storeId);
        try {
            $this->resource->save($homeslider);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $homeslider;
    }

    /**
     * Load Homeslider data by given Homeslider Identity
     *
     * @param string $homesliderId
     * @return Homeslider
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($homesliderId)
    {
        $homeslider = $this->homesliderFactory->create();
        $this->resource->load($homeslider, $homesliderId);
        if (!$homeslider->getId()) {
            throw new NoSuchEntityException(__('Ktpl Homeslider with id "%1" does not exist.', $homesliderId));
        }
        return $homeslider;
    }

    /**
     * Load Homeslider data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Ktpl\Homeslider\Model\ResourceModel\Homeslider\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->homesliderCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $homesliders = [];
        /** @var Homeslider $homesliderModel */
        foreach ($collection as $homesliderModel) {
            $homesliderData = $this->dataHomesliderFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $homesliderData,
                $homesliderModel->getData(),
                'Ktpl\Homeslider\Api\Data\HomesliderInterface'
            );
            $homesliders[] = $this->dataObjectProcessor->buildOutputDataArray(
                $homesliderData,
                'Ktpl\Homeslider\Api\Data\HomesliderInterface'
            );
        }
        $searchResults->setItems($homesliders);
        return $searchResults;
    }

    /**
     * Delete Homeslider
     *
     * @param \Ktpl\Homeslider\Api\Data\HomesliderInterface $homeslider
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\HomesliderInterface $homeslider)
    {
        try {
            $this->resource->delete($homeslider);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Homeslider by given Homeslider Identity
     *
     * @param string $homesliderId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($homesliderId)
    {
        return $this->delete($this->getById($homesliderId));
    }
}
