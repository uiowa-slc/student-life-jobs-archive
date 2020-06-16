<?php

use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\Form;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Control\Controller;

class JobSearchBlock extends BaseElement {

	private static $db = array(

    );

    private static $has_one = array(
        'JobListingHolder' => 'JobListingHolder',
        'BackgroundImage' => Image::class

    );
    private static $many_many = array(

    );

    private static $controller_class = JobSearchBlockController::class;

    private static $table_name = 'JobSearchBlock';

    public function getType()
    {
        return 'Job Holder Search Block';
    }

    public function getCMSFields(){
        $fields = parent::getCMSFields();

        $field = DropdownField::create('JobListingHolderID', 'Select a Job Holder:', JobListingHolder::get()->map('ID', 'Title'));
        $fields->addFieldToTab('Root.Main', $field);
        $fields->addFieldToTab("Root.Main", new UploadField("BackgroundImage", "Background Image"));

        return $fields;
    }

    public function TopicSearchForm(){
        //$current = Controller::curr();
        $controller = JobListingHolderController::create($this);
        $current = $this->getController();

        $jobliStingholder = $this->JobListingHolder();

        $controller->setRequest($current->getRequest());
        //print_r($this->getController());
        $form = $controller->TopicSearchFormSized();


        $form->setFormAction(
            Controller::join_links(
                $jobliStingholder->Link(),
                'SearchForm'
            )
        );
        return $form;
    }


}
