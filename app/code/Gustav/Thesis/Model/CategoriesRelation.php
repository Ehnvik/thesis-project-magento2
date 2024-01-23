<?php
namespace Gustav\Thesis\Model;

use Magento\Framework\Model\AbstractModel;

class CategoriesRelation extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel\CategoriesRelation::class);
    }
}
