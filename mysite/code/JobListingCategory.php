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

class JobListingCategory extends JobListingCategorisationObject
{

    protected static $primaryTerm = 'category';
    protected static $primaryTermPlural = 'categories';

    public function listingFeedURL(){
       return Environment::getEnv('JOBFEED_BASE').'positions.json?category_id='.$this->ID;
    }

    public function Parent(){
        $holder = JobListingHolder::get()->First();
        //echo 'hello'
        return $holder;
    }

    public function Link(){
        $holder = JobListingHolder::get()->First();
        return $holder->Link('category/'.$this->ID);
    }

    public static function getByID($id, $term = 'category', $termPlural = 'categories'){
        return parent::getByID($id, $term, $termPlural);
    }

    public function Locations($status = "open"){
        $jobList = new ArrayList();
        $jobList = $this->JobListings($status);
        $locations = new ArrayList();

        foreach($jobList as $job){
             // print_r($job.' Location: '.$job->Location.'<br />');
            if($job->Location && !($locations->byID($job->Location->ID))){
                $locations->push($job->Location);
            }
        }

        return $locations;


    }

}
