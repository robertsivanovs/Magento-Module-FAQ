<?php

declare(strict_types=1);

/**
 * Mass delete action in FAQ add/edit form
 */
namespace Learning\Faq\Controller\Adminhtml\Question;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Learning\Faq\Model\ResourceModel\Question\CollectionFactory;

use Learning\Faq\Api\QuestionRepositoryInterface;

/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action {

    protected $filter;
    protected $collectionFactory;

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepositoryInterface;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        QuestionRepositoryInterface $questionRepository
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->questionRepository = $questionRepository;

        parent::__construct($context);
    }

    /**
     * execute
     *
     * Deletes all selected FAQ entries via questionRepository
     *
     * @return void
     */
    public function execute() {

        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $question) {
            $this->questionRepository->deleteById((int) $question->getId());
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
