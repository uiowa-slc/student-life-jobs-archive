<?php

class JobListing extends Topic {

	private static $db = array (
		'PayRate' => 'Text',
		'BasicJobFunction' => 'HTMLText',
		'LearningOutcomes' => 'HTMLText',
		'NextStepTitle' => 'Text',
		'NextStepLink' => 'Text',
		'Location' => 'Text'
	);

	private static $defaults = array(
		'NextStepTitle' => 'Learn more and apply'
	);

	private static $many_many = array(

	);

	private static $belongs_many_many = array(

	);


	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		$fields->removeByName('TopicQuestions');
		$fields->removeByName('Tags');
		$fields->removeByNaMe('ExternalURL');
		$fields->removeByName('Content');


		$fields->addFieldToTab('Root.Main', TextField::create('PayRate','Rate of pay'));
		$fields->addFieldToTab('Root.Main', TextField::create('Location','Location of position (physical location, not department)'));
		$fields->addFieldToTab('Root.Main', TextField::create('NextStepLink','Next step link (please include http://)'));
		$fields->addFieldToTab('Root.Main', TextField::create('NextStepTitle','Next step link title (default: Learn more and apply)'));
		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('BasicJobFunction','Basic job function')->setRows(2));
		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('LearningOutcomes','What you will learn')->setRows(2));

		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content','Additional content or instructions needed in order to apply'));

		return $fields;

	}

}


class JobListing_Controller extends Topic_Controller{



}