<?php

declare(strict_types=1);

/**
 * Question collection
 */

namespace Learning\Faq\Model\ResourceModel\Question;

/**
 * Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(
			Learning\Faq\Model\Question::class,
			Learning\Faq\Model\ResourceModel\Question::class
		);
	}
}
