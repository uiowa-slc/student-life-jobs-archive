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
		$fields->removeByName('TopicQuestions');
		return $fields;
	}




}


class JobListingHolder_Controller extends TopicHolder_Controller{
	
	private static $allowed_actions = array(
        'department',
    );

    private static $url_handlers = array(
        'department/$Department!/$Rss' => 'department',
    );

    public function ThreeColumnedListings($column){
        $total = $this->getBlogPosts()->Count;
        $perColumn = floor($total / 3);

        switch ($column){
            case 1:
                $posts = $this->getBlogPosts()->Limit(3);
                break;
            case 2:
                $posts = $this->getBlogPosts()->Limit(3, 3 + $perColumn);
                break;
            case 3:
                $posts = $this->getBlogPosts()->Limit(9999, 6 + $perColumn);

        }

        return $posts; 
    }
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

    /** 
     * Returns true if the $Rss sub-action for categories/tags has been set to "rss"
     */
    private function isRSS() 
    {
        $rss = $this->request->param('Rss');
        if(is_string($rss) && strcasecmp($rss, "rss") == 0) {
            return true;
        } else {
            return false;
        }
    }
}