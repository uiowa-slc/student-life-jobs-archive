<?php

use SilverStripe\Blog\Model\Blog;
use SilverStripe\TagField\TagField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Control\Controller;
class JobListing extends Page {

	private static $db = array (
		'PayRate' => 'Text',
		'Active' => 'Boolean',
		'BasicJobFunction' => 'HTMLText',
		'LearningOutcomes' => 'HTMLText',
		'NextStepTitle' => 'HTMLText',
		'NextStepLink' => 'HTMLText',
		'Location' => 'Text',
		'Qualifications' => 'HTMLText',
		'Responsibilities' => 'HTMLText',
		'WorkHours' => 'HTMLText',
		'TrainingRequirements' => 'HTMLText',
		'CategoryID' => 'Int'
	);

	private static $defaults = array(
		'NextStepTitle' => 'Learn more and apply'
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

    public function Parent(){
    	$holder = JobListingHolder::get()->First();
    	//echo 'hello'
    	return $holder;
    }

    // public function getBreadcrumbItems($maxDepth = 20, $stopAtPageType = false, $showHidden = false)
    // {
    //     // $page = $this;
    //     // $pages = array();

    //     // while ($page
    //     //     && $page->exists()
    //     //     && (!$maxDepth || count($pages) < $maxDepth)
    //     //     && (!$stopAtPageType || $page->ClassName != $stopAtPageType)
    //     // ) {
    //     //     if ($showHidden || $page->ShowInMenus || ($page->ID == $this->ID)) {
    //     //         $pages[] = $page;
    //     //     }

    //     //     $page = $page->Parent();
    //     // }

    //     // return new ArrayList(array_reverse($pages));
    // }

                // "id": 4,
                // "title": "Dishwasher",
                // "department_id": 14,
                // "location_id": 21,
                // "category_id": 10,
                // "job_code": "S150",
                // "criminal_background_check_required": true,
                // "drivers_license_required": false,
                // "offer_letter_required": false,
                // "acknowledgement_form_required": false,
                // "class_schedule_required": false,
                // "bbp_training_required": false,
                // "rate_of_pay": "$9.50/hour",
                // "work_location": "Iowa Memorial Union",
                // "what_you_will_learn": "You can expect to learn skills such as time management, conflict resolution, balancing priorities, attention to detail, interpersonal communication, customer service experience, and working with people from diverse backgrounds and working as part of a team.  Although your job in the Division of Student Life may not be directly related to your future profession, the skills you learn here will help you in your chosen career path and give you valuable work experience to strengthen your resume.",
                // "basic_job_function": "Perform various tasks including the preparation and cooking of food, and cleaning/sanitation duties which support the operations of a large-scale food service operation",
                // "responsibilities": "Work with kitchen staff on catering and special events\r\nAssist in restocking kitchen and keep area organized\r\nWork in dish area including scraping, cleaning and putting away dishes\r\nClean and sanitize tables and other surfaces.  Follow proper procedures including sweeping and mopping\r\nRespond to customer inquiries or problems in a courteous manner\r\nDemonstrate civil and respectful interactions with others\r\nDress in proper work attire per department guidelines\r\nOther duties as assigned",
                // "qualifications": "Enrolled as student at the University of Iowa(during academic year)\r\nDemonstrated commitment to GREAT customer service\r\nMust be a motivated self-starter and able to complete tasks in a timely manner with minimal supervision\r\nGood communication skills (written and verbal) and be positive and respectful in working with a diverse population\r\nMust be dependable and reliable\r\nMust be able to work through finals week\r\nMust be able to move up to 20 pounds and stand for long periods of time",
                // "work_hours": null,
                // "training_requirements": "Safety Training for Dining Students",
                // "active": true


/*		'PayRate' => 'Text',
		'Active' => 'Boolean',
		'BasicJobFunction' => 'HTMLText',
		'LearningOutcomes' => 'HTMLText',
		'NextStepTitle' => 'HTMLText',
		'NextStepLink' => 'HTMLText',
		'Location' => 'Text',
		'Qualifications' => 'HTMLText',
		'Responsibilities' => 'HTMLText',
		'WorkHours' => 'HTMLText',
		'TrainingRequirements' => 'HTMLText',

		*/

    public function Link($action = null)
    {
        $holder = JobListingHolder::get()->First();

        return $holder->Link('show/'.$this->ID);
    }

	public function parseFromFeed($rawJob) {

		$this->ID = $rawJob['id'];
		$this->Title = $rawJob['title'];


		if(isset($rawJob['category_id'])){
			$this->Category = new JobListingCategory();
			$this->Category = $this->Category->getByID($rawJob['category_id']);

		}
		if(isset($rawJob['department_id'])){
			$this->Department = new JobListingDepartment();
			$this->Department = $this->Department->getByID($rawJob['department_id']);
		}

		if(isset($rawJob['training_requirements'])) $this->TrainingRequirements = $rawJob['training_requirements'];
		if(isset($rawJob['responsibilities'])) $this->Responsibilities = $rawJob['responsibilities'];
		if(isset($rawJob['qualifications'])) $this->Qualifications = $rawJob['qualifications'];
		if(isset($rawJob['basic_job_function'])) $this->BasicJobFunction = $rawJob['basic_job_function'];
		if(isset($rawJob['what_you_will_learn'])) $this->LearningOutcomes = $rawJob['what_you_will_learn'];
		if(isset($rawJob['work_location'])) $this->Location = $rawJob['work_location'];
		if(isset($rawJob['work_hours'])) $this->WorkHours = $rawJob['work_hours'];
		if(isset($rawJob['rate_of_pay'])) $this->PayRate = $rawJob['rate_of_pay'];
		if(isset($rawJob['active'])) $this->Active = $rawJob['active'];
		
		return $this;

	}

	public function Related(){
		// $holder = $this->Parent();
		// $tags = $this->Categories()->limit(6);
		// $entries = new ArrayList();

		// foreach($tags as $tag){
		// 	$taggedEntries = $tag->BlogPosts()->exclude(array("ID"=>$this->owner->ID))->sort('PublishDate', 'ASC')->Limit(3);
		// 	if($taggedEntries){
		// 		foreach($taggedEntries as $taggedEntry){
		// 			if($taggedEntry->ID){
		// 				$entries->push($taggedEntry);
		// 			}
		// 		}
		// 	}

		// }
		// $thisEntry = $entries->filter(array('ID' => $this->ID))->First();

		// $entries->remove($thisEntry);
		// if($entries->count() > 1){
		// 	$entries->removeDuplicates();
		// }
		// return $entries;
	}

	public function NextStepDomain(){
		$url = $this->NextStepLink;

		$parsedUrl = parse_url($url);
		if(isset($parsedUrl['host'])){
			$domain = $parsedUrl['host'];
			return $domain;
		}

	}
}
