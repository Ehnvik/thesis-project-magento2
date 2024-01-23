<?php
namespace Gustav\Thesis\Block\Frontend;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Gustav\Thesis\Model\ResourceModel\Stores\CollectionFactory as StoreCollectionFactory;

class StoreLocator extends Template
{
    protected StoreCollectionFactory $storeCollectionFactory;

    public function __construct(
        Context $context,
        StoreCollectionFactory $storeCollectionFactory,
        array $data = []
    ) {
        $this->storeCollectionFactory = $storeCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getStores(): array
    {
        $collection = $this->storeCollectionFactory->create();
        return $collection->getItems();
    }
}
