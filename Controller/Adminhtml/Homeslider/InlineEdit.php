<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Controller\Adminhtml\Homeslider;

use Magento\Backend\App\Action\Context;
use Ktpl\Homeslider\Api\HomesliderRepositoryInterface as HomesliderRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Ktpl\Homeslider\Api\Data\HomesliderInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var HomesliderRepository  */
    protected $homesliderRepository;

    /** @var JsonFactory  */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param HomesliderRepository $homesliderRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        HomesliderRepository $homesliderRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->homesliderRepository = $homesliderRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $homesliderId) {
                    /** @var \Ktpl\Homeslider\Model\Homeslider $homeslider */
                    $homeslider = $this->homesliderRepository->getById($homesliderId);
                    try {
                        $homeslider->setData(array_merge($homeslider->getData(), $postItems[$homesliderId]));
                        $this->homesliderRepository->save($homeslider);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithHomesliderId(
                            $homeslider,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add homeslider title to error message
     *
     * @param HomesliderInterface $homeslider
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithHomesliderId(HomesliderInterface $homeslider, $errorText)
    {
        return '[Homeslider ID: ' . $homeslider->getId() . '] ' . $errorText;
    }
}
