<?php

use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataExtension;

/**
 * Adds URLSegment functionality to Tags & Categories.
 *
 * @package silverstripe
 * @subpackage blog
 */
class HomePageExtension extends DataExtension {

	public function JobListingHolder() {
		return JobListingHolder::get()->First();
	}
	public function TopicSearchForm() {
		$current = Controller::curr();
		$controller = JobListingHolderController::create($this->owner);

		$joblistingHolder = JobListingHolder::get()->First();

		$controller->setRequest($current->getRequest());
		//print_r($this->getController());
		$form = $controller->TopicSearchFormSized();

		$form->setFormAction(
			Controller::join_links(
				$joblistingHolder->Link(),
				'SearchForm'
			)
		);
		return $form;
	}
}
