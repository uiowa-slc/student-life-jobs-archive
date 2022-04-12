<?php

use SilverStripe\Blog\Model\Blog;
use SilverStripe\Core\Environment;

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

class JobListingDepartment extends JobListingCategorisationObject {
	protected static $primaryTerm = 'department';
	protected static $primaryTermPlural = 'departments';

	public function listingFeedURL() {
		return Environment::getEnv('JOBFEED_BASE') . 'feed/positions.json?department_id=' . $this->ID;
	}
	public function Parent() {
		$holder = JobListingHolder::get()->First();
		//echo 'hello'
		return $holder;
	}
	/**
	 * Returns a relative URL for the tag link.
	 *
	 * @return string
	 */
	public function Link() {

		$holder = JobListingHolder::get()->First();

		$link = $holder->Link('department/' . $this->ID);

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
	public static function getByID($id, $term = 'department', $termPlural = 'departments') {
		return parent::getByID($id, $term, $termPlural);
	}
    public static function getByIDNoCount($id, $term = 'department', $termPlural = 'departments') {
        return parent::getByIDNoCount($id, $term, $termPlural);
    }
}
