<?php
/**
 * Model for QuestionSearchResultsInterface
 */
declare(strict_types=1);

namespace Learning\Faq\Model;

use Learning\Faq\Api\Data\QuestionSearchResultsInterface;
use Magento\Framework\Api\SearchResults;


/**
 * QuestionSearchResults
 */
class QuestionSearchResults extends SearchResults implements QuestionSearchResultsInterface
{
}
