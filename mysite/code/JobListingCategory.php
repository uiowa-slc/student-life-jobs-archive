<?php

use SilverStripe\Blog\Model\Blog;
use SilverStripe\Core\Environment;
use SilverStripe\ORM\ArrayList;

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

class JobListingCategory extends JobListingCategorisationObject {

	protected static $primaryTerm = 'category';
	protected static $primaryTermPlural = 'categories';

	public function listingFeedURL() {
		return Environment::getEnv('JOBFEED_BASE') . 'feed/positions.json?category_id=' . $this->ID;
	}

	public function Parent() {
		$holder = JobListingHolder::get()->First();
		//echo 'hello'
		return $holder;
	}

	public function Link() {
		$holder = JobListingHolder::get()->First();

		$link = $holder->Link('category/' . $this->ID);

		if (strpos($link, '?stage=Stage') !== false) {
			$link = str_replace("stage=Stage&", "", $link);
			$link = str_replace("stage=Stage", "", $link);
		}
		if (strpos($link, '?stage=Live') !== false) {
			$link = str_replace("stage=Live&", "", $link);
			$link = str_replace("stage=Live", "", $link);
		}

		return $link;
	}

	public static function getByID($id, $term = 'category', $termPlural = 'categories') {
		return parent::getByID($id, $term, $termPlural);
	}
    public static function getByIDNoCount($id, $term = 'category', $termPlural = 'categories') {
        return parent::getByIDNoCount($id, $term, $termPlural);
    }
	public function Locations($status = "open") {
		$jobList = new ArrayList();
		$jobList = $this->JobListings($status);
		$locations = new ArrayList();

		foreach ($jobList as $job) {
			// print_r($job.' Location: '.$job->Location.'<br />');
			if ($job->Location && !($locations->byID($job->Location->ID))) {
				$locations->push($job->Location);
			}
		}

		return $locations;

	}

}
