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

class JobListingLocation extends JobListingCategorisationObject
{

    protected static $primaryTerm = 'location';
    protected static $primaryTermPlural = 'locations';

    public function listingFeedURL(){
       return Environment::getEnv('JOBFEED_BASE').'positions.json?location_id='.$this->ID;
    }
    public function Parent(){
        $holder = JobListingHolder::get()->First();
        //echo 'hello'
        return $holder;
    }
    /**
     * Returns a relative URL for the tag link.
     *
     * @return string

     */
    public function Link()
    {
        $holder = JobListingHolder::get()->First();
        $link = $holder->Link('location/'.$this->ID);

        if(strpos($link, '?stage=Stage') !== false){
            $link = str_replace("stage=Stage&", "", $link);
            $link = str_replace("stage=Stage", "", $link);
        }
        if(strpos($link, '?stage=Live') !== false){
            $link = str_replace("stage=Live&", "", $link);
            $link = str_replace("stage=Live", "", $link);
        }

        return $link;
    }


    public function JobListingsByFilter($status = 'open'){
        // $term = 'category';
        // $termPlural = 'categories';

        $controller = Controller::curr();
        $id = $controller->urlParams['ID'];
        $term = $controller->urlParams['Action'];

        $feedURL = Environment::getEnv('JOBFEED_BASE').'positions.json?location_id='.$this->ID.'&'.$term.'_id='.$id;

        if($status == 'open'){
            $feedURL .= '&open=true';
        }elseif($status == 'closed'){
            $feedURL .= '&closed=true';
        }elseif($status == 'all'){

        }

        //print_r($feedURL);
        $jobList = new ArrayList();
        $jobFeed = FeedHelper::getJson($feedURL);


        if (isset($jobFeed['positions'])) {
            $jobArray = $jobFeed['positions'];
            foreach ($jobArray as $job) {
                if (isset($job)) {
                    $jobObj = new JobListing();
                    $jobObj = $jobObj->parseFromFeed($job['position']);

                //If the job is active, shift it to the top of the arraylist to show it first. Otherwise add to end of list.
                   if($jobObj->Active){

                        $jobList->unshift($jobObj);
                    }else{
                        $jobList->push($jobObj);
                    }

                }
            }
            //print_r($jobList);

        }

        return $jobList;
        //All of this is not needed because we have positions.json?location_id&category_id

        // $catObjName = "JobListing".ucfirst($term);
        // $catObj = new $catObjName;

        // $catObj = $catObj->getById($id);


        // if(!$catObj){
        //     return false;
        // }

        // $jobList = $catObj->JobListings();

        // if($jobList){

        //     foreach($jobList as $job){


        //         if($job->Category->ID == $id){
        //             $jobListFiltered->push($job->Location->ID);
        //         }
        //     }
        // }



    }


    public static function getByID($id, $term = 'location', $termPlural = 'locations'){
        return parent::getByID($id, $term, $termPlural);
    }
}
