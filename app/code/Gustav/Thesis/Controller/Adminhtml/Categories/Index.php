<?php

namespace Gustav\Thesis\Controller\Adminhtml\Categories;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected PageFactory $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute(): ResultInterface
    {
        return $this->resultPageFactory->create();
    }

    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Gustav_Thesis::manage_categories');
    }
}
