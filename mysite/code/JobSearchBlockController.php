<?php


use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\Form;
use DNADesign\Elemental\Controllers\ElementController;
class JobSearchBlockController extends ElementController {

        private static $allowed_actions = array(
            'JobSearchForm',
            'submit'

        );

        protected $jobListingHolderController;

        protected function init()
        {
            parent::init();
            $controller = $this->getJobListingHolderController() ?: JobListingHolderController::create($this->element);
            $controller->setRequest($this->getRequest());
            $controller->doInit();
            $this->setJobListingHolderController($controller);
        }

         public function submit($data, $form){

            $jobListingHolder = $this->JobListingHolder();
            $query = $data['Search'];
             print_r($query);

            // return $this->redirect($jobListingHolder->Link() . 'JobSearchForm?Search=' . $query . '&action_results=Search');
        }
        /**
         * Return the associated UserDefinedFormController
         *
         * @return UserDefinedFormController
         */
        public function getJobListingHolderController()
        {
            return $this->jobListingHolderController;
        }
        /**
         * Set the associated UserDefinedFormController
         *
         * @param UserDefinedFormController $controller
         * @return $this
         */
        public function setJobListingHolderController(JobListingHolderController $controller)
        {
            $this->jobListingHolderController = $controller;
            return $this;
        }
}
