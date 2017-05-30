<?php

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

        $fields->addFieldToTab('Root.Main', HTMLEditorField::create('MoreInfoText', 'Text to display under each "Apply now" button'));
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
        $total = $this->getBlogPosts()->Count();
        $perColumn = floor($total / 3);
        //echo $perColumn.' ';
        $allPosts = $this->getBlogPosts()->sort('Title ASC');
        switch ($column){
            case 1:
                $posts = $allPosts->Limit($perColumn);
                break;
            case 2:
                $posts = $allPosts->Limit($perColumn, $perColumn + $column);
                break;
            case 3:
                $posts = $allPosts->Limit(9999, $perColumn * 2 + $column);

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
    public function IsFilterActive(){
        if($this->getCurrentCategory() || $this->getCurrentDepartment() || $this->getCurrentTag()){
            return true;
        }
        return false;
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
     * Returns true if the $Rss sub-action for categories/departments has been set to "rss"
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