<?php

class JobListingHolder extends TopicHolder {

	private static $db = array(

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
		//$fields->addFieldToTab("Root.Settings", new CheckboxField('ExpandAllTopicsByDefault', 'Expand all topics by default'));

		$fields->removeByName('TopicQuestions');
		return $fields;

	}



}


class JobListingHolder_Controller extends TopicHolder_Controller{
	
	private static $allowed_actions = array(
        'department',
    );

    public function department(){
        $department = $this->getCurrentDepartment();

        if ($department) {
            $this->jobListings = $department->JobListings();

            if($this->isRSS()) {
            	return $this->rssFeed($this->jobListings, $department->getLink());
            } else {
            	return $this->render();
            }
        }

        $this->httpError(404, 'Not Found');

        return null;
    }

    public function getCurrentDepartment()
    {
        /**
         * @var Blog $dataRecord
         */
        $dataRecord = $this->dataRecord;
        $department = $this->request->param('Department');
        if ($department) {
            return $dataRecord->Departments()
                ->filter('URLSegment', array($department, rawurlencode($department)))
                ->first();
        }
        return null;
    }


}