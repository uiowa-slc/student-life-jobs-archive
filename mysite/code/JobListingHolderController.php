<?php
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\View\ArrayData;
use SilverStripe\Core\Environment;
class JobListingHolderController extends PageController{

    private static $allowed_actions = array(
        'show',
        'department',
        'category'
    );

    // private static $url_handlers = array(
    //     'show/$ID' => 'show',
    //     'department/$ID' => 'department',
    //     'category/$ID' => 'category'
    // );

// https://apps-test.housing.uiowa.edu/seo/feed/positions.json


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

    public function TopicSearchFormSized($size = "large"){

        return $this->TopicSearchForm($this, 'SearchForm', null, null, $size);
    }

    public function TopicSearchForm($request, $name, $fields, $actions, $size = "large") {
        return new TopicSearchForm($this, 'SearchForm', null, null, $size);
    }


    public function show(){
        $id = $this->urlParams['ID'];

        if (!is_numeric($id)) {
            //return $this->httpError( 404);
        }

        $job = $this->singleJob($id);

        if($job){
            return $this->customise($job)->renderWith(array('JobListing', 'Page'));
        }

        // print_r($job);

    }

    public function department(){
        // $department = new JobListingDepartment();
        // $department->ID = 8;
        // $department->Title = 'Test';
        $department = $this->getCurrentDepartment();

        //print_r($department);

        if ($department) {

            $data = new ArrayData([
                'FilterType' => 'Department',
                'FilterTitle' => $department->Title,
                'FilterList' => $department->JobListings()
            ]);

            return $this->customise($data)->renderWith(array('JobListingHolder', 'Page'));
        }

        //=$this->httpError(404, 'Not Found');

        return null;
    }
    public function category(){
        // $department = new JobListingDepartment();
        // $department->ID = 8;
        // $department->Title = 'Test';
        $category = $this->getCurrentCategory();

        //print_r($department);

        if ($category) {

            $data = new ArrayData([
                'FilterType' => 'Category',
                'FilterTitle' => $category->Title,
                'FilterList' => $category->JobListings()
            ]);

            return $this->customise($data)->renderWith(array('JobListingHolder', 'Page'));
        }

        //=$this->httpError(404, 'Not Found');

        return null;
    }
    public function location(){
        // $department = new JobListingDepartment();
        // $department->ID = 8;
        // $department->Title = 'Test';
        $location = $this->getCurrentLocation();

        //print_r($department);

        if ($location) {

            $data = new ArrayData([
                'FilterType' => 'Location',
                'FilterTitle' => $location->Title,
                'FilteredList' => $location->JobListings()
            ]);

            return $this->customise($data)->renderWith(array('JobListingHolder', 'Page'));
        }

        //=$this->httpError(404, 'Not Found');

        return null;
    }
    public function IsFilterActive(){
        if($this->getCurrentCategory() || $this->getCurrentDepartment()){
            return true;
        }
        return false;
    }
    public function getCurrentDepartment()
    {
        $depID = $this->request->param('ID');
        if (is_numeric($depID)) {
            $dep = JobListingDepartment::getByID($depID);
            return $dep;
        }
    }
    public function getCurrentCategory()
    {

        $catID = $this->request->param('ID');
        if (is_numeric($catID)) {
            $cat = JobListingCategory::getByID($catID);
            return $cat;
        }
    }
    public function getCurrentLocation()
    {

        $locID = $this->request->param('ID');
        if (is_numeric($locID)) {
            $loc = JobListingLocation::getByID($locID);
            return $loc;
        }
    }
    protected function init() {
        parent::init();

    }
}
