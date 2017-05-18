<?php

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

class JobListingDepartment extends DataObject implements CategorisationObject
{

    private static $db = array(
        'Title' => 'Varchar(255)',
    );

    private static $has_one = array(
        'Blog' => 'JobListingHolder',
    );

    private static $belongs_many_many = array(
        'JobListings' => 'JobListing',
    );

    private static $extensions = array(
        'URLSegmentExtension',
    );

    
    public function JobListing()
    {
        $jobListings = parent::JobListings();

        $this->extend("updateGetJobListings", $jobListings);

        return $jobListings;
    }

    /**
     * {@inheritdoc}
     */
    public function getCMSFields()
    {
        $fields = new FieldList(
            TextField::create('Title', _t('JobListingDepartment.Title', 'Title'))
        );

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * Returns a relative URL for the tag link.
     *
     * @return string
     */
    public function getLink()
    {
        return Controller::join_links($this->Blog()->Link(), 'department', $this->URLSegment);
    }

    /**
     * Inherits from the parent blog or can be overwritten using a DataExtension.
     *
     * @param null|Member $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);

        if ($extended !== null) {
            return $extended;
        }

        return $this->Blog()->canView($member);
    }

    /**
     * Inherits from the parent blog or can be overwritten using a DataExtension.
     *
     * @param null|Member $member
     *
     * @return bool
     */
    public function canCreate($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);

        if ($extended !== null) {
            return $extended;
        }

        $permission = Blog::config()->grant_user_permission;

        return Permission::checkMember($member, $permission);
    }

    /**
     * Inherits from the parent blog or can be overwritten using a DataExtension.
     *
     * @param null|Member $member
     *
     * @return bool
     */
    public function canDelete($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);

        if ($extended !== null) {
            return $extended;
        }

        return $this->Blog()->canEdit($member);
    }

    /**
     * Inherits from the parent blog or can be overwritten using a DataExtension.
     *
     * @param null|Member $member
     *
     * @return bool
     */
    public function canEdit($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);

        if ($extended !== null) {
            return $extended;
        }

        return $this->Blog()->canEdit($member);
    }
}