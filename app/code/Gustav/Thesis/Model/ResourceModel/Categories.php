<?php

namespace Gustav\Thesis\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Categories extends AbstractDb
{
    /**
     * Define main table and primary key
     */
    protected function _construct(): void
    {
        $this->_init('store_categories', 'category_id');
    }
}
