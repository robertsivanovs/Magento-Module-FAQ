<?php

declare(strict_types=1);

/**
 * Front end controller for displaying FAQ
 */
namespace Learning\Faq\Controller\Adminhtml\Question;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Index
 */
class Index extends Action
{
    /**
     * execute
     *
     * @return void
     */
    public function execute()
	{
		return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
