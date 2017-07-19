<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Block\Adminhtml\Homeslider\Edit;

use Magento\Backend\Block\Widget\Context;
use Ktpl\Homeslider\Api\HomesliderRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var HomesliderRepositoryInterface
     */
    protected $homesliderRepository;

    /**
     * @param Context $context
     * @param HomesliderRepositoryInterface $homesliderRepository
     */
    public function __construct(
        Context $context,
        HomesliderRepositoryInterface $homesliderRepository
    ) {
        $this->context = $context;
        $this->homesliderRepository = $homesliderRepository;
    }

    /**
     * Return Ktpl homeslider ID
     *
     * @return int|null
     */
    public function getHomesliderId()
    {
        try {
            return $this->homesliderRepository->getById(
                $this->context->getRequest()->getParam('homeslider_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
