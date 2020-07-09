<?php
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\View\ArrayData;
use SilverStripe\Core\Environment;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\ORM\Search\FulltextSearchable;
use SilverStripe\CMS\Search\SearchForm;

class JobListingHolderController extends PageController{

    private static $allowed_actions = array(
        'show',
        'department',
        'category',
        'location',
        'results',
        'SearchForm',
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
        $form = $this->TopicSearchForm($this, 'SearchForm', null, null, $size);


        return $form;
    }

    public function TopicSearchForm($request, $name, $fields, $actions, $size = "large") {
        $form = new TopicSearchForm($request, $name, $fields, $actions, $size = "large");
        $field = $form->Fields()->First();

        $field->setAttribute('placeholder', 'Search for currently open jobs');
        return $form;
    }


    public function show(){
        $id = $this->urlParams['ID'];

        if (!is_numeric($id)) {
            return $this->httpError( 404);
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

        if(!$department){
            return $this->httpError(404);
        }

        $openClosed = $this->getFilterOpenClosed();

        //print_r($department);
        if($openClosed == 'all'){
            $jobList = $department->JobListings('all');
            $filterTitle = 'All jobs listed under "'.$department->Title.'":';
        }else{
            $jobList = $department->JobListings();
            $filterTitle = 'Currently hiring jobs listed under "'.$department->Title.'":';
        }

        if ($department) {

            $data = new ArrayData([
                'Filter' => $department,
                'FilterType' => 'Department',
                'FilterTitle' => $department->Title,
                'FilterList' => $jobList
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

        if(!$category){
            return $this->httpError(404);
        }

        $openClosed = $this->getFilterOpenClosed();

        //print_r($department);

        if ($category) {

            if($openClosed == 'all'){
                $jobList = $category->JobListings('all');
                $filterTitle = 'All jobs listed under "'.$category->Title.'":';
            }else{
                $jobList = $category->JobListings();
                $filterTitle = 'Currently hiring jobs listed under "'.$category->Title.'":';
            }


            $data = new ArrayData([
                'Filter' => $category,
                'FilterType' => 'Category',
                'FilterTitle' => $filterTitle,
                'FilterList' => $jobList,
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

        if(!$location){
            return $this->httpError(404);
        }
        $openClosed = $this->getFilterOpenClosed();
        //print_r($department);
        if($openClosed == 'all'){

            $filterTitle = 'All jobs listed at '.$location->Title.':';
        }else{

            $filterTitle = 'Currently hiring jobs listed at '.$location->Title.':';
        }

        if ($location) {

            $data = new ArrayData([
                'Filter' => $location,
                'FilterType' => 'Location',
                'FilterTitle' => $filterTitle
            ]);

            return $this->customise($data)->renderWith(array('JobListingHolder', 'Page'));
        }

        //=$this->httpError(404, 'Not Found');

        return null;
    }

    public function getFilterOpenClosed(){
        $openClosed = $this->request->param('OtherID');
        return $openClosed;
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
    /**
     * Site search form
     *
     * @return SearchForm
     */
    public function SearchForm()
    {
        $searchText = '';
        if ($this->owner->getRequest() && $this->owner->getRequest()->getVar('Search')) {
            $searchText = $this->owner->getRequest()->getVar('Search');
        }

        $placeholder = _t('SilverStripe\\CMS\\Search\\SearchForm.SEARCH', 'Search');
        $fields = FieldList::create(
            TextField::create('Search', false, $searchText)
                ->setAttribute('placeholder', $placeholder)
        );
        $actions = FieldList::create(
            FormAction::create('results', _t('SilverStripe\\CMS\\Search\\SearchForm.GO', 'Go'))
        );
        /** @skipUpgrade */
        $form = SearchForm::create($this->owner, 'SearchForm', $fields, $actions);
        $form->classesToSearch(FulltextSearchable::get_searchable_classes());
        return $form;
    }
    /**
     * Process and render search results.
     *
     * @param array $data The raw request data submitted by user
     * @param SearchForm $form The form instance that was submitted
     * @param SS_HTTPRequest $request Request generated for this action
     */
    public function results($data, $form) {

        $results = $this->getSearchResults();

        //print_r($results);

        //$resultsFiltered = $results->filter(array('ParentID' => $this->owner->ID));

        $data = array(
            'JobListings' => $results->JobListings,
            'JobCats' => $results->JobCats,
            'Query' => DBField::create_field('Text', $form->getSearchQuery()),
            'Title' => _t('SearchForm.SearchResults', 'Search Results'),
            'Holder' => $this->owner
        );


        return $this->owner->customise($data)->renderWith(array($this->owner->ClassName.'_results', 'TopicHolder_results', 'Page'));
    }

    private function getSearchResults(){
       // Get request data from request handler
        $request = $this->request;
        $keywords = $request->requestVar('Search');

        //TODO: apply basic search term filtering
        $allJobs = $this->JobListings('open');

        $allCats = $this->CatObjects('open');
       // print_r($allCats);

       //print_r($allJobs->First());

        //$filteredJobs = $allJobs->filter(array('Title:PartialMatch' => 'Accommodation Assistant - Level 1'));
        $filteredJobs = $allJobs->filterByCallback(function($item, $list) use ($keywords) {
            return $item->SearchListing($keywords);
            });
        $filteredCats = $allCats->filterByCallback(function($item, $list) use ($keywords) {
            return $item->SearchObj($keywords);
            });

        $data = new ArrayData(array(
            'JobListings' => $filteredJobs,
            'JobCats' => $filteredCats

        ));

      // print_r($data);

        return $data;


    }

}
