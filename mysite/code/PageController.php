<?php
use SilverStripe\CMS\Controllers\ContentController;

class PageController extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array(
		'SearchForm',
		'autoComplete',
		'autoCompleteResults',
	);

	protected function init() {
		parent::init();

	}

	public function SearchForm() {
		$jobHolder = JobListingHolder::get()->First();
		$searchTerm = $this->getRequest()->getVar('Search');

		$this->redirect($jobHolder->Link('SearchForm?Search=' . $searchTerm));
	}

	//Disable autocomplete results
	public function autoCompleteResults($data, $form, $request) {
		return null;
		// $data = array(
		//     'Results' => $form->getResults(),
		//     'Query' => $form->getSearchQuery(),
		//     'Title' => _t('SearchForm.SearchResults', 'Search Results')
		// );
		// return $this->owner->customise($data)->renderWith(array('Page_results', 'Page'));
	}
	public function autoComplete($request) {
		return null;
		// $keyword = trim( $request->requestVar( 'query' ) );

		// $keyword = Convert::raw2sql( $keyword );

		// $pages = new ArrayList();
		// $pagesArray = array();

		// $suggestions = array('suggestions' => array());

		// $pages = SiteTree::get()->filter(array(
		//     'Title:PartialMatch' =>  $keyword,
		//     'ShowInSearch' => 1
		//     // 'Content:PartialMatch' => $keyword
		// ))->limit(5);

		// //$pagesArray = $pages->map()->toArray();
		// $pagesArray = $pages->column('Title');
		// $suggestions['suggestions'] = $pagesArray;
		// // if(!$this->in_arrayi($keyword, $pagesArray)){
		// //  array_unshift($pagesArray, $keyword);
		// // }

		// return json_encode($suggestions);

	}
}
