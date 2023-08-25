<?php

declare(strict_types=1);

/**
 * Deletes current FAQ entry
 */
namespace Learning\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Learning\Faq\Api\QuestionRepositoryInterface;

/**
 * Delete FAQ Question.
 */
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepository;

    public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->questionRepository = $questionRepository;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = (int) $this->getRequest()->getParam('id');

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $question = $this->questionRepository->getById($id);
                $this->questionRepository->deleteById((int) $question->getId());

                // display success message
                $this->messageManager->addSuccessMessage(__('The Question has been deleted.'));

                return $resultRedirect->setPath('*/*/');

            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['page_id' => $id]);
            }
        }

        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Question to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
