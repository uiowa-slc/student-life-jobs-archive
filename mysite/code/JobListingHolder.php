<?php

class JobListingHolder extends TopicHolder {

	private static $db = array(

	);

	private static $allowed_children = array('JobListing');

    public function getLumberjackTitle() {
        return 'Job Listings';
    }

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		//$fields->addFieldToTab("Root.Settings", new CheckboxField('ExpandAllTopicsByDefault', 'Expand all topics by default'));

		$fields->removeByName('TopicQuestions');
		return $fields;

	}



}


class JobListingHolder_Controller extends TopicHolder_Controller{



}