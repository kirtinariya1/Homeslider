<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Model\Homeslider\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \Ktpl\Homeslider\Model\Homeslider
     */
    protected $cmsHomeslider;

    /**
     * Constructor
     *
     * @param \Ktpl\Homeslider\Model\Homeslider $cmsHomeslider
     */
    public function __construct(\Ktpl\Homeslider\Model\Homeslider $cmsHomeslider)
    {
        $this->cmsHomeslider = $cmsHomeslider;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->cmsHomeslider->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
