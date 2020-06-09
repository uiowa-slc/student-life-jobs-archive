<?php

use SilverStripe\Dev\BuildTask;
use SilverStripe\Core\Environment;
class JobListingRemoveDeptFromTitleTask extends BuildTask{

	protected $title = 'Job Listings - remove "IMU - "ish text from titles ';

	protected $enabled = false;

	function run($request){
		increase_time_limit_to();
		$needles = array(
			'IMU - ',
			'UH&D - ',
			'Rec Svcs - '
		);

		echo '<p>Gathering all job listings..</p>';
		$pages = JobListing::get();
		echo '<ul>';
		foreach($pages as $page){

			$title = $page->Title;
			$parsedTitle = str_replace($needles, '', $title);

			echo '<li> Renamed '.$title.' to <strong>'.$parsedTitle.'</strong></li>';
			$page->Title = $parsedTitle;
			$page->write();

			if($page->isPublished()){
				$page->publish('Stage', 'Live');
			}

		}
		echo '</ul>';

	}

}
