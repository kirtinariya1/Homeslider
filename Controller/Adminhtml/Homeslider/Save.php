<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Controller\Adminhtml\Homeslider;

use Magento\Backend\App\Action\Context;
use Ktpl\Homeslider\Model\Homeslider;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;

class Save extends \Ktpl\Homeslider\Controller\Adminhtml\Homeslider
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            $id = $this->getRequest()->getParam('homeslider_id');

            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Homeslider::STATUS_ENABLED;
            }
            if (empty($data['homeslider_id'])) {
                $data['homeslider_id'] = null;
            }
            
            if(isset($data['image'][0]['name'])){
                $data['image'] = $data['image'][0]['name'];
            }else{
                $data['image'] = null;
            }

            /** @var \Ktpl\Homeslider\Model\Homeslider $model */
            $model = $this->_objectManager->create('Ktpl\Homeslider\Model\Homeslider')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This homeslider no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }          
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the homeslider.'));
                $this->dataPersistor->clear('ktpl_homeslider');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['homeslider_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the homeslider.'));
            }

            $this->dataPersistor->set('ktpl_homeslider', $data);
            return $resultRedirect->setPath('*/*/edit', ['homeslider_id' => $this->getRequest()->getParam('homeslider_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
