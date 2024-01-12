<?php
namespace Gustav\Thesis\Controller\Adminhtml\StoreLocator;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Gustav\Thesis\Model\StoreLocatorFactory;
use Gustav\Thesis\Model\ResourceModel\StoreLocator as StoreLocatorResource;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $storeLocatorFactory;
    protected $storeLocatorResource;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreLocatorFactory $storeLocatorFactory,
        StoreLocatorResource $storeLocatorResource
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->storeLocatorFactory = $storeLocatorFactory;
        $this->storeLocatorResource = $storeLocatorResource;
    }

    public function execute()
    {
        $storeId = $this->getRequest()->getParam('store_id');
        $resultPage = $this->resultPageFactory->create();
        $title = $resultPage->getConfig()->getTitle();

        if ($storeId) {
            $storeLocator = $this->storeLocatorFactory->create();
            $this->storeLocatorResource->load($storeLocator, $storeId);

            if (!$storeLocator->getId()) {
                $this->messageManager->addErrorMessage(__('This store no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }

            $title->prepend(__($storeLocator->getStoreName()));
        } else {
            $title->set(__('New Store'));
        }

        return $resultPage;
    }
}
