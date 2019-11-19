<?php

use SilverStripe\Blog\Admin\GridFieldCategorisationConfig;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Control\Director;

class JobListingHolder extends Page {

	private static $db = array(
		'MoreInfoText' => 'HTMLText'
	);

    // private static $has_many = array(
    //     'Departments' => 'JobListingDepartment',
    // );

	private static $allowed_children = array('JobListing');

    public function getLumberjackTitle() {
        return 'Job Listings';
    }

	public function getCMSFields(){
		$fields = parent::getCMSFields();

		return $fields;
	}


    /*feed/positions.json (all positions)
feed/positions.json?open=true
feed/positions.json?closed=true
feed/positions.json?department_id=14
feed/positions.json?department=University+Housing+and+Dining
feed/positions.json?category_id=1
feed/positions.json?category=Food+Service
feed/positions.json?location_id=21
feed/positions.json?location=CRWC
feed/positions.json?category_id=1&location_id=8
feed/positions.json?category_id&location_id=8&open=true
etc.

Also,
feed/departments.json
feed/categories.json
feed/locations.json */


    public function Jobs($open = true){

        $feedURL = JOBFEED_BASE.'positions.json';

        $jobList = new ArrayList();
        $jobFeed = $this->getJson($feedURL);


        if (isset($jobFeed['positions'])) {
            $jobArray = $jobFeed['positions'];
            foreach ($jobArray as $job) {
                if (isset($job)) {
                    $jobObj = new JobListing();

                    $jobList->push($jobObj->parseFromFeed($job['position']));
                }
            }
            //print_r($jobList);
            return $jobList;
        }

    }

    public function Departments(){
        $feedURL = JOBFEED_BASE.'departments.json';

        $deptList = new ArrayList();
        $deptFeed= $this->getJson($feedURL);

        //print_r($deptFeed);

        if (isset($deptFeed['departments'])) {
            $deptArray = $deptFeed['departments'];
            foreach ($deptArray as $dept) {
                if (isset($dept)) {
                    $deptObj = new JobListingDepartment();

                    $deptList->push($deptObj->parseFromFeed($dept['department']));
                }
            }
            //print_r($jobList);
            return $deptList;


        }
    }

    public function Categories(){
        $feedURL = JOBFEED_BASE.'categories.json';

        $catList = new ArrayList();
        $catFeed= $this->getJson($feedURL);

        //print_r($catFeed);

        if (isset($catFeed['categories'])) {
            $catArray = $catFeed['categories'];
            foreach ($catArray as $cat) {
                if (isset($cat)) {
                    $catObj = new JobListingCategory();

                    $catList->push($catObj->parseFromFeed($cat['category']));
                }
            }
            //print_r($jobList);
            return $catList;


        }
    }

    public function Locations(){
        $feedURL = JOBFEED_BASE.'locations.json';

        $locationList = new ArrayList();
        $locationFeed= $this->getJson($feedURL);

        print_r($locationFeed);

        if (isset($locationFeed['locations'])) {
            $locationArray = $locationFeed['locations'];
            foreach ($locationArray as $location) {
                if (isset($location)) {
                    $locationObj = new JobListingLocation();

                    $locationList->push($locationObj->parseFromFeed($location['location']));
                }
            }
            //print_r($jobList);
            return $locationList;


        }
    }

    public function singleJob($id) {

        if (!isset($id) || $id == 0) {
            return false;
        }

        if(!is_numeric($id)){
            return false;
        }

        $feedURL = JOBFEED_BASE.'positions.json?id='.$id;

        $jobFeed = $this->getJson($feedURL);
        // print_r($jobFeed);
        if(isset($jobFeed['positions'][0])){
            $job = $jobFeed['positions'][0]['position'];
        }
        print_r($job);
        if (isset($job)) {
            $jobObj = new JobListing();
            $parsedJob  = $jobObj->parseFromFeed($job);
            return $parsedJob;
        }
        return false;
    }





}