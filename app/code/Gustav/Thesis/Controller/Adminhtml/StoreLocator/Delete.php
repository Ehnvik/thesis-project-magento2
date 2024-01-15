<?php
namespace Gustav\Thesis\Controller\Adminhtml\StoreLocator;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Gustav\Thesis\Model\StoreLocatorFactory;
use Gustav\Thesis\Model\ResourceModel\StoreLocator as StoreLocatorResource;

class Delete extends Action
{
    protected StoreLocatorFactory $storeLocatorFactory;
    protected StoreLocatorResource $storeLocatorResource;

    public function __construct(
        Context $context,
        StoreLocatorFactory $storeLocatorFactory,
        StoreLocatorResource $storeLocatorResource
    ) {
        parent::__construct($context);
        $this->storeLocatorFactory = $storeLocatorFactory;
        $this->storeLocatorResource = $storeLocatorResource;
    }

    public function execute()
    {
        $redirect = $this->resultRedirectFactory->create();
        $storeId = $this->getRequest()->getParam('store_id');

        if (!$storeId) {
            $this->messageManager->addErrorMessage(__('No store found to delete.'));
            return $redirect->setPath('*/*/index');
        }

        try {
            $storeLocator = $this->storeLocatorFactory->create();
            $this->storeLocatorResource->load($storeLocator, $storeId);

            if ($storeLocator->getId()) {
                $this->storeLocatorResource->delete($storeLocator);
                $this->messageManager->addSuccessMessage(__('Store has been successfully deleted.'));
            } else {
                $this->messageManager->addErrorMessage(__('Store could not be found.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error occurred while deleting the store: %1', $e->getMessage()));
        }

        return $redirect->setPath('*/*/index');
    }
}
