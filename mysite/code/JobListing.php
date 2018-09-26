<?php

class JobListing extends Topic {

	private static $db = array (
		'PayRate' => 'Text',
		'BasicJobFunction' => 'HTMLText',
		'LearningOutcomes' => 'HTMLText',
		'NextStepTitle' => 'HTMLText',
		'NextStepLink' => 'HTMLText',
		'Location' => 'Text',
		'Qualifications' => 'HTMLText',
		'Responsibilities' => 'HTMLText',
		'WorkHours' => 'HTMLText',
		'TrainingRequirements' => 'HTMLText',
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

	public function getCMSFields(){
		
		$fields = parent::getCMSFields();

        $self =& $this;
        $parent = $self->Parent();
		$departments = $parent instanceof Blog
                ? $parent->Departments()
                : JobListingDepartment::get();

		$departmentField = TagField::create(
                    'Departments',
                    _t('JobListing.Departments', 'Departments'),
                    $departments,
                    $self->Departments()
                )
                    ->setCanCreate($self->canCreateDepartments())
                    ->setShouldLazyLoad(true);

		$fields->addFieldToTab("blog-admin-sidebar", $departmentField);
		$fields->removeByName('Authors');
		$fields->removeByName('Questions');
		$fields->removeByName('IsFeatured');
		$fields->removeByName('SummaryQuestions');
		$fields->removeByName('ExternalURL');

		$fields->removeByName('Tags');
		$fields->removeByName('Tags');

		
		$fields->removeByName('Content');
		$fields->removeByName('LayoutType');


		$fields->renameField('Title', 'Job title');

		$fields->addFieldToTab('Root.Main', TextField::create('PayRate','Rate of pay'));
		$fields->addFieldToTab('Root.Main', TextField::create('Location','Work location (physical location, not department)'));

		$fields->addFieldToTab('Root.Main', TextField::create('NextStepLink','Next step link (please include http://)'));
		$fields->addFieldToTab('Root.Main', TextField::create('NextStepTitle','Next step link title (default: Learn more and apply)'));


		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('LearningOutcomes','What you will learn'));

		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('BasicJobFunction','Basic job function'));

		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('Responsibilities'));

		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('Qualifications', 'Qualifications'));

		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('WorkHours'));

		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('TrainingRequirements'));

		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content','Additional content or instructions needed in order to apply'));

		return $fields;

	}

	 public function canCreateDepartments($member = null)
    {
        $member = $this->getMember($member);

        $parent = $this->Parent();

        if (!$parent || !$parent->exists() || !($parent instanceof Blog)) {
            return false;
        }

        if ($parent->isEditor($member)) {
            return true;
        }

        return Permission::checkMember($member, 'ADMIN');
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();

        foreach ($this->Departments() as $department) {
            
            $department->BlogID = $this->ParentID;
            $department->write();
        }
    }
	public function Related(){
		$holder = $this->Parent();
		$tags = $this->Categories()->limit(6);
		$entries = new ArrayList();

		foreach($tags as $tag){
			$taggedEntries = $tag->BlogPosts()->exclude(array("ID"=>$this->owner->ID))->sort('PublishDate', 'ASC')->Limit(3);
			if($taggedEntries){
				foreach($taggedEntries as $taggedEntry){
					if($taggedEntry->ID){
						$entries->push($taggedEntry);
					}
				}
			}

		}
		$thisEntry = $entries->filter(array('ID' => $this->ID))->First();

		$entries->remove($thisEntry);
		if($entries->count() > 1){
			$entries->removeDuplicates();
		}
		return $entries;
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


class JobListing_Controller extends Topic_Controller{

	


}