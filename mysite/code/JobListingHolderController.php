<?php
class JobListingHolderController extends PageController{
	
	private static $allowed_actions = array(
        'show',
        'department',
    );

    private static $url_handlers = array(
        'show/$ID' => 'show',
        'department/$Department!/$Rss' => 'department',
    );
//  You can query positions with parameters, like so…

// feed/positions.json (all positions)
// feed/positions.json?open=true
// feed/positions.json?closed=true
// feed/positions.json?department_id=14
// feed/positions.json?department=University+Housing+and+Dining
// feed/positions.json?category_id=1
// feed/positions.json?category=Food+Service
// feed/positions.json?location_id=21
// feed/positions.json?location=CRWC
// feed/positions.json?category_id=1&location_id=8
// feed/positions.json?category_id&location_id=8&open=true
// etc.

// Also,
// feed/departments.json
// feed/categories.json
// feed/locations.json

// There are four positions currently in the test data:

// [Name, Department, Location, Category, open/closed]
// Dishwasher, University Housing and Dining, Iowa Memorial Union, Food Service, closed
// Catering Lead, University Housing and Dining, Iowa Memorial Union, Catering, open
// Aquatic Equipment Technician I, Recreational Services, CRWC, Aquatics, open
// Dining Associate, University Housing and Dining, Burge Residence Hall, Food Service, closed
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


    public function show(){


        $id = $this->urlParams['ID'];

        if (!is_numeric($id)) {
            return $this->httpError( 404);
        }

        $job = $this->singleJob($id);

        print_r($job);

        return $this->customise($job)->renderWith(array('JobListing', 'Page'));  



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
        // if($this->getCurrentCategory() || $this->getCurrentDepartment() || $this->getCurrentTag()){
        //     return true;
        // }
        // return false;
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
    public function isRSS() 
    {
        $rss = $this->request->param('Rss');
        if(is_string($rss) && strcasecmp($rss, "rss") == 0) {
            return true;
        } else {
            return false;
        }
    }
}