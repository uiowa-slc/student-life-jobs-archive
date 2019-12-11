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

class JobListingCategorisationObject extends DataObject implements CategorisationObject
{

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText'
    );

    private static $primaryTerm;
    private static $primaryTermPlural;

    private static $feedURL;

    public function listingFeedURL(){
        print_r(JOBFEED_BASE.'positions.json?'.self::$primaryTerm.'_id='.$this->ID);
       return JOBFEED_BASE.'positions.json?'.self::$primaryTerm.'_id='.$this->ID;
    }

    public function getJson($feedURL) {
        $cache = new SimpleCache();
        if ($rawFeed = $cache->get_data($feedURL, $feedURL)) {
            $eventsDecoded = json_decode($rawFeed, TRUE);
        } else {
            $rawFeed = $cache->do_curl($feedURL);
            $cache->set_cache($feedURL, $rawFeed);
            $eventsDecoded = json_decode($rawFeed, TRUE);
        }

        if (!empty($eventsDecoded)) {
            return $eventsDecoded;
        } else {
            return false;
        }
    }

    public function JobListings(){
        $feedURL = $this->listingFeedURL();

        $jobList = new ArrayList();
        $jobFeed = $this->getJson($feedURL);

        if (isset($jobFeed['positions'])) {
            $jobArray = $jobFeed['positions'];
            foreach ($jobArray as $job) {
                if (isset($job)) {
                    $jobObj = new JobListing();

                    $jobList->push($jobObj->parseFromFeed($job['position']));
                }
            }
            //print_r($jobList);
            return $jobList;
        }
    }

    public function parseFromFeed($rawDept) {

        $this->ID = $rawDept['id'];
        $this->Title = $rawDept['name'];
        return $this;
    }

    public function BlogPosts(){
        // return $this->JobListings();
    }

    /**
     * {@inheritdoc}
     */
    public function getCMSFields(){
        $fields = new FieldList(
            TextField::create('Title', _t('JobListingDepartment.Title', 'Title')),
            HTMLEditorField::create('Content', 'Description of department')
        );

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    /**
     * Returns a relative URL for the tag link.
     *
     * @return string
     */
    public function getLink(){

        return Controller::join_links($this->Blog()->Link(), 'department', $this->URLSegment);
    }


}