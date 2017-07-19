<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Homeslider\Controller\Adminhtml\Homeslider;

class Delete extends \Ktpl\Homeslider\Controller\Adminhtml\Homeslider
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('homeslider_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Ktpl\Homeslider\Model\Homeslider');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the homeslider.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['homeslider_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a homeslider to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
