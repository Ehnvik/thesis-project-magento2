<?php

namespace Gustav\Thesis\Controller\Adminhtml\StoreLocator;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Gustav\Thesis\Model\ResourceModel\StoreLocator\CollectionFactory as StoreLocatorCollectionFactory;
use Gustav\Thesis\Model\ResourceModel\StoreLocator as StoreLocatorResource;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var StoreLocatorCollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var StoreLocatorResource
     */
    protected $storeLocatorResource;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param StoreLocatorCollectionFactory $collectionFactory
     * @param StoreLocatorResource $storeLocatorResource
     * @param Filter $filter
     */
    public function __construct(
        Context                       $context,
        StoreLocatorCollectionFactory $collectionFactory,
        StoreLocatorResource          $storeLocatorResource,
        Filter                        $filter
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->storeLocatorResource = $storeLocatorResource;
        $this->filter = $filter;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $storesDeleted = 0;

            foreach ($collection->getItems() as $storeLocator) {
                $this->storeLocatorResource->delete($storeLocator);
                $storesDeleted++;
            }

            if ($storesDeleted) {
                $this->messageManager->addSuccessMessage(
                    __('A total of %1 store(s) have been deleted.', $storesDeleted)
                );
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred while deleting stores.'));
        }

        $redirect->setPath('*/*/index');
        return $redirect;
    }
}
