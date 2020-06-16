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
use SilverStripe\Core\Environment;
use quamsta\ApiCacher\FeedHelper;
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

    protected static $primaryTerm;
    protected static $primaryTermPlural;

    private static $feedURL;



    public function JobListings($status = 'open'){

        $feedURL = Environment::getEnv('JOBFEED_BASE').'positions.json?'.static::$primaryTerm.'_id='.$this->ID;

        if($status == 'open'){
            $feedURL .= '&open=true';
        }elseif($status == 'closed'){
            $feedURL .= '&closed=true';
        }elseif($status == 'all'){

        }

        // print_r($feedURL);
        $jobList = new ArrayList();
        $jobFeed = FeedHelper::getJson($feedURL);

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

        if(isset($rawDept['active_job_postings'])){
            $this->ActiveJobListings = $rawDept['active_job_postings'];
        }

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




}
