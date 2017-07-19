<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Model;

use Ktpl\Homeslider\Api\Data\HomesliderInterface;
use Ktpl\Homeslider\Model\ResourceModel\Homeslider as ResourceCmsHomeslider;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * CMS homeslider model
 *
 * @method ResourceCmsHomeslider _getResource()
 * @method ResourceCmsHomeslider getResource()
 * @method Homeslider setStoreId(array $storeId)
 * @method array getStoreId()
 */
class Homeslider extends AbstractModel implements HomesliderInterface, IdentityInterface
{
    /**
     * CMS homeslider cache tag
     */
    const CACHE_TAG = 'ktpl_homeslider';

    /**#@+
     * Homeslider's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**#@-*/
    /**
     * @var string
     */
    protected $_cacheTag = 'ktpl_homeslider';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'ktpl_homeslider';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ktpl\Homeslider\Model\ResourceModel\Homeslider');
    }
  
    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Retrieve homeslider id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::HOMESLIDER_ID);
    }

    /**
     * Retrieve homeslider identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return (string)$this->getData(self::IDENTIFIER);
    }

    /**
     * Retrieve homeslider title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Retrieve homeslider content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Retrieve homeslider creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve homeslider update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return HomesliderInterface
     */
    public function setId($id)
    {
        return $this->setData(self::HOMESLIDER_ID, $id);
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return HomesliderInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return HomesliderInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return HomesliderInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    public function setImage($image)
    {
        return $this->setData(self::CONTENT, $image);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return HomesliderInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return HomesliderInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return HomesliderInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store_id');
    }

    /**
     * Prepare homeslider's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
