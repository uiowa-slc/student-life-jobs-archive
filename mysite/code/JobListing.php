<?php

class JobListing extends Topic {

	private static $many_many = array(
        'Departments' => 'JobListingDepartment',
	);

	private static $belongs_many_many = array(

	);


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

		$fields->removeByName('TopicQuestions');
		$fields->renameField('ExternalURL', 'Hire A Hawk Link (please include https://)');
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
            
            $department->JobListingHolderID = $this->ParentID;
            $department->write();
        }
    }

}


class JobListing_Controller extends Topic_Controller{

	


}