<?php

declare(strict_types=1);

/**
 * Question ResourceModel.
 */
namespace Learning\Faq\Model\ResourceModel;

use Learning\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Question
 */
class Question extends AbstractDb
{
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(
            QuestionInterface::TABLE_NAME,
            QuestionInterface::ID
        );
    }
}
