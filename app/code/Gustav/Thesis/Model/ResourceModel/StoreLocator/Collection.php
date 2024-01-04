<?php
namespace Gustav\Thesis\Model\ResourceModel\StoreLocator;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Gustav\Thesis\Model\StoreLocator as Model;
use Gustav\Thesis\Model\ResourceModel\StoreLocator as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
