<?php

use quamsta\ApiCacher\FeedHelper;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Blog\Model\CategorisationObject;
use SilverStripe\Core\Environment;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;

/**
 * A department for keyword descriptions of a job listing location.
 *
 * @package silverstripe
 * @subpackage blog
 *
 * @method Blog Blog()
 *
 * @property string $Title
 * @property string $URLSegment
 * @property int $BlogID
 */

class JobListingCategorisationObject extends DataObject implements CategorisationObject {

	private static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
	);

	protected static $primaryTerm;
	protected static $primaryTermPlural;

	private static $feedURL;

	public static function getByID($id, $term, $termPlural) {
		$feedURL = Environment::getEnv('JOBFEED_BASE') . 'feed/' . $termPlural . '.json?id=' . $id;
		$catObjName = "JobListing" . ucfirst($term);
		$catObj = new $catObjName;
		$catFeed = FeedHelper::getJson($feedURL);

		if (isset($catFeed[$termPlural][0])) {
			//print_r($catFeed[$termPlural][0]['location']);
			$catObj = $catObj->parseFromFeed($catFeed[$termPlural][0][$term]);
			// print_r($catObj);
			return $catObj;

		}

	}
	public function SearchObj($keywords) {

		$haystack = $this->Title . ' ' . $this->Content;

		if (stripos($haystack, $keywords) !== false) {
			return true;
		}

	}
	public function JobListings($status = 'open') {

		$feedURL = Environment::getEnv('JOBFEED_BASE') . 'feed/positions.json?' . static::$primaryTerm . '_id=' . $this->ID;

		if ($status == 'open') {
			$feedURL .= '&open=true';
		} elseif ($status == 'closed') {
			$feedURL .= '&closed=true';
		} elseif ($status == 'all') {

		}

		//print_r($feedURL.'<br />');
		$jobList = new ArrayList();
		$jobFeed = FeedHelper::getJson($feedURL);
		// print_r($feedURL);
		if (isset($jobFeed['positions'])) {
			$jobArray = $jobFeed['positions'];
			foreach ($jobArray as $job) {
				if (isset($job)) {
					$jobObj = new JobListing();
					$jobObj = $jobObj->parseFromFeed($job['position']);
					//If the job is active, shift it to the top of the arraylist to show it first. Otherwise add to end of list.
					if ($jobObj->Active) {
						//echo $jobObj->Title.'<br />';
						$jobList->unshift($jobObj);
					} else {
						$jobList->push($jobObj);
					}

				}
			}
			//print_r($jobList);
			return $jobList;
		}
	}

	public function parseFromFeed($rawDept) {

		$this->ID = $rawDept['id'];
		$this->Title = $rawDept['name'];

		if (isset($rawDept['active_job_postings'])) {
			$this->ActiveJobListings = $rawDept['active_job_postings'];
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCMSFields() {
		$fields = new FieldList(
			TextField::create('Title', _t('JobListingDepartment.Title', 'Title')),
			HTMLEditorField::create('Content', 'Description of department')
		);

		$this->extend('updateCMSFields', $fields);
		return $fields;
	}

	public function Locations($status = 'open') {

		$jobList = $this->JobListings($status);
		$locations = new ArrayList();

		foreach ($jobList as $job) {
			//print_r($job.' Location: '.$job->Location.'<br />');
			if ($job->Location) {
				$locations->push($job->Location);
			}
		}

		$locations->removeDuplicates();

		return $locations;

	}

}
