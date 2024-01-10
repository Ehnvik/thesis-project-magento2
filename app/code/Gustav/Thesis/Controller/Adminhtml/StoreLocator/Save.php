<?php
namespace Gustav\Thesis\Controller\Adminhtml\StoreLocator;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Gustav\Thesis\Model\StoreLocatorFactory;
use Gustav\Thesis\Model\ResourceModel\StoreLocator as StoreLocatorResource;
use Magento\Framework\App\Request\DataPersistor;

class Save extends Action
{
    protected PageFactory $resultPageFactory;
    protected StoreLocatorFactory $storeLocatorFactory;
    protected StoreLocatorResource $storeLocatorResource;
    protected DataPersistor $dataPersistor;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreLocatorFactory $storeLocatorFactory,
        StoreLocatorResource $storeLocatorResource,
        DataPersistor $dataPersistor
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->storeLocatorFactory = $storeLocatorFactory;
        $this->storeLocatorResource = $storeLocatorResource;
        $this->dataPersistor = $dataPersistor;
    }

public function execute()
    {
        $redirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->messageManager->addErrorMessage(__('No data to save.'));
            return $redirect->setPath('*/*/');
        }

        try {
            $storeId = $data['store_id'] ?? null;
            $storeLocator = $this->storeLocatorFactory->create();

            if ($storeId) {
                $this->storeLocatorResource->load($storeLocator, $storeId);
            }

            $storeLocator->setData($data);
            $this->storeLocatorResource->save($storeLocator);

            $this->messageManager->addSuccessMessage(__('Store has been successfully saved.'));
            return $redirect->setPath('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error occurred while saving store: %1', $e->getMessage()));
            return $redirect->setPath('*/*/newstore');
        }
    }
}


