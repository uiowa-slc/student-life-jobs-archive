<?php

use SilverStripe\Blog\Admin\GridFieldCategorisationConfig;
use SilverStripe\Forms\GridField\GridField;

class JobListingHolder extends TopicHolder {

	private static $db = array(
		'MoreInfoText' => 'HTMLText'
	);

    private static $has_many = array(
        'Departments' => 'JobListingDepartment',
    );

	private static $allowed_children = array('JobListing');

    public function getLumberjackTitle() {
        return 'Job Listings';
    }

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('TopicQuestions');
		$fields->removeByName('Tags');
        $self =& $this;

        $departments = GridField::create(
            'Departments',
            _t('Blog.Departments', 'Departments'),
            $self->Departments(),
            GridFieldCategorisationConfig::create(15, $self->Departments()->sort('Title'), 'JobListingDepartment', 'Departments', 'BlogPosts')
        );


        $fields->addFieldsToTab('Root.Categorisation', array(
            $departments
        ));

        // $fields->addFieldToTab('Root.Main', HTMLEditorField::create('MoreInfoText', 'Text to display under each "Apply now" button'));
		return $fields;
	}


}