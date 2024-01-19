<?php
namespace Gustav\Thesis\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Stores extends AbstractDb
{
    /**
     * Define main table and primary key
     */
    protected function _construct(): void
    {
        $this->_init('store_locator', 'store_id');
    }
}
