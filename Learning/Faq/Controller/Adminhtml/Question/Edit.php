<?php

declare(strict_types=1);

/**
 * FAQ Question Edit
 */
namespace Learning\Faq\Controller\Adminhtml\Question;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Learning\Faq\Api\QuestionRepositoryInterface;

/**
 * Edit Question.
 */
class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     *
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->questionRepository = $questionRepository;
        parent::__construct($context);
    }

    /**
     * Edit Question
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): \Magento\Framework\Controller\ResultInterface
    {
        // 1. Get Question ID
        $id = (int) $this->getRequest()->getParam('id');

        if ($id) {
            $question = $this->questionRepository->getById($id);

            if (!$question->getId()) {
                $this->messageManager->addErrorMessage(__('This question no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        return $resultPage;
    }

}
