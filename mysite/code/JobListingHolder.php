<?php

use quamsta\ApiCacher\FeedHelper;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\ORM\ArrayList;

class JobListingHolder extends Page {

	private static $db = array(
		'MoreInfoText' => 'HTMLText',
	);

	// private static $has_many = array(
	//     'Departments' => 'JobListingDepartment',
	// );

	private static $allowed_children = array('JobListing');

	public function getLumberjackTitle() {
		return 'Job Listings';
	}

	public function getCMSFields() {
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
	*/

	public function JobListings($status = 'open') {

		$feedURL = Environment::getEnv('JOBFEED_BASE') . 'feed/positions.json?';

		if ($status == 'open') {
			$feedURL = Director::absoluteBaseURL().'/public/api/open-jobs.json';
		} elseif ($status == 'closed') {
			$feedURL .= '&closed=true';
		} elseif ($status == 'any') {

		}

		$jobList = new ArrayList();
		$jobFeed = FeedHelper::getJson($feedURL);

		if (isset($jobFeed['positions'])) {
			$jobArray = $jobFeed['positions'];
			foreach ($jobArray as $job) {
				if (isset($job)) {
					$jobObj = new JobListing();

					$jobList->push($jobObj->parseFromFeed($job['position']));
				}
			}
			//print_r($jobList);

		}

		return $jobList;

	}

	public function CategorisationObjects($term, $termPlural, $filterByOpen = false) {

		// $feedURL = Environment::getEnv('JOBFEED_BASE') . 'feed/' . $termPlural . '.json';
        $feedURL = Director::absoluteBaseURL().'public/api/'.$termPlural.'.json';
		$catList = new ArrayList();
		$catFeed = FeedHelper::getJson($feedURL);
		// print_r($feedURL);
		//print_r($catFeed);

		if (isset($catFeed[$termPlural])) {
			$catArray = $catFeed[$termPlural];

			foreach ($catArray as $cat) {
				if (isset($cat)) {

					$catObjName = "JobListing" . ucfirst($term);
					$catObj = new $catObjName;
					$catObj = $catObj->parseFromFeed($cat[$term]);
					if ($filterByOpen == true) {

						if ($catObj->ActiveJobListings > 0) {
							$catList->push($catObj);
						}

					} else {

						if ($catObj->ActiveJobListings > 0) {

							$catList->unshift($catObj);

						} else {

							$catList->push($catObj);
						}
					}

				}
			}
			// if($term == 'location')print_r($feedURL);
            // print_r($feedURL);
			return $catList;

		}

	}

	public function Departments($filterByOpen = false) {
		$departments = $this->CategorisationObjects('department', 'departments', $filterByOpen);
		return $departments;
	}

	public function Categories($filterByOpen = false) {
		$categories = $this->CategorisationObjects('category', 'categories', $filterByOpen);
		return $categories;
	}

	public function Locations($filterByOpen = false) {
		$locations = $this->CategorisationObjects('location', 'locations', $filterByOpen);
		return $locations;
	}

	public function CatObjects($filterByOpen = false) {
		$catObjs = new ArrayList();
		$catObjs->merge($this->Departments($filterByOpen));
		$catObjs->merge($this->Categories($filterByOpen));
		$catObjs->merge($this->Locations($filterByOpen));
		return $catObjs;
	}

	public function singleJob($id) {

		if (!isset($id) || $id == 0) {
			return false;
		}

		if (!is_numeric($id)) {
			return false;
		}

		$feedURL = Environment::getEnv('JOBFEED_BASE') . 'feed/positions.json?id=' . $id;

		$jobFeed = FeedHelper::getJson($feedURL);
		//print_r($feedURL);
		if (isset($jobFeed['positions'][0])) {
			$job = $jobFeed['positions'][0]['position'];
		}
		//print_r($job);
		if (isset($job)) {
			$jobObj = new JobListing();
			$parsedJob = $jobObj->parseFromFeed($job);
			return $parsedJob;
		}
		return false;
	}

	public function urlsToCache() {
		$jobHolder = $this;
		$abs = Director::absoluteBaseURL();
		$jobHolderLink = Director::absoluteURL($jobHolder->Link());

		$urls[$jobHolderLink] = 0;

		//Cache all current jobs from  job list

		$jobs = $jobHolder->JobListings();

		foreach ($jobs as $job) {
			$urls[Director::absoluteURL($job->Link())] = 0;
		}

		$cats = $jobHolder->CatObjects();

		foreach ($cats as $cat) {
			$urls[Director::absoluteURL($cat->Link())] = 0;

			//This works, but it's really slow, don't want to slam the API, will remain uncached for now:
			$urls[Director::absoluteURL($cat->Link()) . '/all'] = 0;
		}

		//print_r($urls);
		return $urls;
		//return [Director::absoluteURL($this->getOwner()->Link()) => 0];
	}

}
