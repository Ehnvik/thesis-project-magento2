<?php
namespace Gustav\Thesis\Model;

use Magento\Framework\Model\AbstractModel;
use Gustav\Thesis\Model\ResourceModel\Stores as ResourceModel;

class Stores extends AbstractModel
{
    /**
     * Initialize resource model
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

}
