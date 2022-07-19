<?php

use SilverStripe\Core\Environment;
use SilverStripe\ORM\ArrayList;

class JobListing extends Page {

	private static $db = array(
		'PayRate' => 'Text',
		'Active' => 'Boolean',
		'BasicJobFunction' => 'HTMLText',
		'LearningOutcomes' => 'HTMLText',
		'NextStepTitle' => 'HTMLText',
		'NextStepLink' => 'HTMLText',
		'Qualifications' => 'HTMLText',
		'Responsibilities' => 'HTMLText',
		'WorkLocation' => 'Text',
		'WorkHours' => 'HTMLText',
		'TrainingRequirements' => 'HTMLText',
		'CategoryID' => 'Int',
		'AcceptsNonHawkIdApplicants' => 'Boolean',
	);

	private static $defaults = array(
		'NextStepTitle' => 'Learn more and apply',
	);

	private static $many_many = array(
		'Departments' => 'JobListingDepartment',
	);

	private static $belongs_many_many = array(

	);

	private static $default_sort = 'Title ASC';

	/**
	 * Returns a list of breadcrumbs for the current page.
	 *
	 * @param int $maxDepth The maximum depth to traverse.
	 * @param boolean|string $stopAtPageType ClassName of a page to stop the upwards traversal.
	 * @param boolean $showHidden Include pages marked with the attribute ShowInMenus = 0
	 *
	 * @return ArrayList
	 */
	public function JobFeedBase() {
		return Environment::getEnv('JOBFEED_BASE');
	}
	public function Parent() {
		$holder = JobListingHolder::get()->First();
		//echo 'hello'
		return $holder;
	}
	public function Link($action = null) {
		$holder = JobListingHolder::get()->First();

		$link = $holder->Link('show/' . $this->ID);

		//Needed for caching due to some weird session switching thing that appends stage to URL
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

	public function parseFromFeed($rawJob) {

		$this->ID = $rawJob['id'];

		if (isset($rawJob['posting_title'])) {
			$this->Title = $rawJob['posting_title'];

		} else {
			$this->Title = $rawJob['title'];
		}

		if (isset($rawJob['category_id'])) {
			$this->Category = new JobListingCategory();
			$this->Category = $this->Category->getByIDNoCount($rawJob['category_id']);

		}
		if (isset($rawJob['department_id'])) {
			$this->Department = new JobListingDepartment();
			$this->Department = $this->Department->getByIDNoCount($rawJob['department_id']);
		}
		if (isset($rawJob['location_id'])) {
			$this->Location = new JobListingLocation();
			$this->Location = $this->Location->getByIDNoCount($rawJob['location_id']);
		}
		if (isset($rawJob['training_requirements'])) {
			$this->TrainingRequirements = $this->convertBullets($rawJob['training_requirements']);
		}

		// if(isset($rawJob['training_requirements'])) $this->TrainingRequirements = $rawJob['training_requirements'];

		if (isset($rawJob['responsibilities'])) {
			$this->Responsibilities = $this->convertBullets($rawJob['responsibilities']);
		}

		// if(isset($rawJob['responsibilities'])) $this->Responsibilities = $rawJob['responsibilities'];

		if (isset($rawJob['qualifications'])) {
			$this->Qualifications = $this->convertBullets($rawJob['qualifications']);
		}

		//if(isset($rawJob['qualifications'])) $this->Qualifications = $rawJob['qualifications'];
		if (isset($rawJob['basic_job_function'])) {
			$this->BasicJobFunction = $rawJob['basic_job_function'];
		}

		if (isset($rawJob['what_you_will_learn'])) {
			$this->LearningOutcomes = $rawJob['what_you_will_learn'];
		}

		//If work location and location are the same, don't set WorkLocation because it's redundant
		if (isset($rawJob['work_location']) && $this->Location) {
			//print_r($this->Location->Title.' '.$rawJob['work_location']);
			if ($rawJob['work_location'] != $this->Location->Title) {
				$this->WorkLocation = $rawJob['work_location'];
			}

		} elseif ($rawJob['work_location']) {
			$this->WorkLocation = $rawJob['work_location'];
		}


		if (isset($rawJob['work_hours'])) {
			$this->WorkHours = $this->convertBullets($rawJob['work_hours']);
		}

		if (isset($rawJob['rate_of_pay'])) {
			$this->PayRate = $rawJob['rate_of_pay'];
		}

		if (isset($rawJob['has_open_job_posting'])) {
			$this->Active = filter_var($rawJob['has_open_job_posting'], FILTER_VALIDATE_BOOLEAN);
		}

		if (isset($rawJob['accepts_non_hawkid_applicants'])) {
			$this->AcceptsNonHawkIdApplicants = filter_var($rawJob['accepts_non_hawkid_applicants'], FILTER_VALIDATE_BOOLEAN);
		}

		if (isset($rawJob['job_posting_url'])) {
			$this->NextStepLink = $rawJob['job_posting_url'];
		}

		//print_r($this);
		return $this;

	}

	private function convertBullets($string) {
		//print_r($string);
		$stringTrimmed = trim($string);
		$stringTrimmed = rtrim($string);
		$stringReplaced = str_replace('<p>', '', $stringTrimmed);
		$stringReplaced = str_replace('</p>', '', $stringReplaced);
		$stringReplaced = str_replace('<br>', '', $stringReplaced);
		$stringReplaced = str_replace('<br/>', '', $stringReplaced);
		$stringReplaced = str_replace('<br />', '', $stringReplaced);

		$arr = explode('•', $stringReplaced);

		foreach ($arr as $item) {
			$item = trim($item);
			$item = rtrim($item);
		}

		$converted = "<ul><li>" . implode("</li><li>", array_filter($arr)) . "</li></ul>";

		$convertedReplaced = str_replace('<li></li>', '', $converted);
		$convertedReplaced = str_replace('<li> </li>', '', $convertedReplaced);
		//print_r($convertedReplaced);

		return $convertedReplaced;

	}

	private function convertSentences($string) {
		$arr = explode('.', $string);
		$converted = "<ul><li>" . implode("</li><li>", array_filter($arr)) . "</li></ul>";

		return $converted;
	}
	private function convertSemicolons($string) {
		$arr = array();
		$arr = explode(';', $string);
		if (count($arr) > 1) {
			$converted = "<ul><li>" . implode("</li><li>", array_filter($arr)) . "</li></ul>";
		} else {
			$converted = $string;
		}

		return $converted;
	}
	public function SearchListing($keywords) {

		$haystack = $this->Title . ' ' . $this->Responsibilities . ' ' . $this->Location;

		if (stripos($haystack, $keywords) !== false) {
			return true;
		}

	}

	public function getStatus() {
		//TODO: Have Mark Fix the status coming out of api
		if ($this->Active) {
			return 'Active (Currently hiring)';
		} else {
			return 'Closed (Not currently hiring)';
		}

	}

	public function NextStepDomain() {
		$url = $this->NextStepLink;

		$parsedUrl = parse_url($url);
		if (isset($parsedUrl['host'])) {
			$domain = $parsedUrl['host'];
			return $domain;
		}

	}
}
