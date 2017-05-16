<?php

class JobListing extends Topic {

	private static $many_many = array(

	);

	private static $belongs_many_many = array(

	);


	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		$fields->removeByName('TopicQuestions');
		$fields->renameField('ExternalURL', 'Hire A Hawk Link (please include https://)');
		return $fields;

	}

}


class JobListing_Controller extends Topic_Controller{



}