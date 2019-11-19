<?php

use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Controller;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\DataObject;
use SilverStripe\Blog\Model\CategorisationObject;
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

class JobListingDepartment extends JobListingCategorisationObject
{

    public function listingFeedURL(){
       return JOBFEED_BASE.'positions.json?department_id='.$this->ID;
    }

    /**
     * Returns a relative URL for the tag link.
     *
     * @return string
     */
    public function getLink()
    {

        return Controller::join_links($this->JobListing()->Link(), 'department', $this->URLSegment);
    }


}
