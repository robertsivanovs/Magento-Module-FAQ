<?php

declare(strict_types=1);

/**
 * Block for displaying FAQ
 */
namespace Learning\Faq\Block;

use Learning\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\View\Element\Template\Context;

class QuestionList extends \Magento\Framework\View\Element\Template
{

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepositoryInterface;

	public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository
        )
	{
        $this->questionRepository = $questionRepository;
		parent::__construct($context);
	}

	/**
	 * displayFaqData
     *
     * Returns FAQ items
	 *
	 * @return array
	 */
	public function displayFaqData(): array
	{
        $faqData = $this->questionRepository->get()->getItems();
		$sortedfaqData = $this->sortFaq($faqData);

		return $sortedfaqData;
	}

    /**
	 * sortFaq
	 *
	 * Sorts FAQ questions in ascending order
	 *
	 * @param  array $faqData
	 * @return array
	 */
	public function sortFaq (array $faqData): array
	{

		if (!$faqData) {
			return $faqData;
		}

		$nums = [];
		$data = [];

		foreach ($faqData as $question) {
			$nums[] = $question->getPosition();
		}

		sort($nums);

		foreach ($nums as $num) {
			foreach ($faqData as $question) {
				if ($num == $question->getPosition()) {
					$data[] = $question;
				}
			}
		}
		return $data;
	}
}
