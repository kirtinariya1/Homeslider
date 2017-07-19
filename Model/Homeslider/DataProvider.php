<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Model\Homeslider;

use Ktpl\Homeslider\Model\ResourceModel\Homeslider\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Ktpl\Homeslider\Model\ResourceModel\Homeslider\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $homesliderCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $homesliderCollectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $homesliderCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->_storeManager = $storeManager;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Ktpl\Homeslider\Model\Homeslider $homeslider */
        foreach ($items as $homeslider) {
            $homesliderData = $homeslider->getData();
            $mediaUrl = $this ->_storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ); 
            $imageurlpath = $mediaUrl.'homesliderimage/'.$homeslider->getData('image');
            if (isset($homesliderData['image'])) {                
                unset($homesliderData['image']);               
                $homesliderData['image'][0]['name'] = $homeslider->getData('image');
                $homesliderData['image'][0]['url'] = $imageurlpath;
            }
            $this->loadedData[$homeslider->getId()] = $homesliderData;
        }

        $data = $this->dataPersistor->get('ktpl_homeslider');
        if (!empty($data)) {
            $homeslider = $this->collection->getNewEmptyItem();
            $homeslider->setData($data);
            $this->loadedData[$homeslider->getId()] = $homeslider->getData();
            $this->dataPersistor->clear('ktpl_homeslider');
        }

        return $this->loadedData;
    }
}
