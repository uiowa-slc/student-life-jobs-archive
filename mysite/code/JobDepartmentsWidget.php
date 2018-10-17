<?php

use SilverStripe\Widgets\Model\Widget;
use SilverStripe\Forms\FieldList;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Core\Convert;

if (!class_exists(Widget::class)) {
    return;
}

/**
 * @method Blog Blog()
 */
class JobDepartmentsWidget extends Widget
{
    /**
     * @var string
     */
    private static $title = 'Departments';

    /**
     * @var string
     */
    private static $cmsTitle = 'Departments';

    /**
     * @var string
     */
    private static $description = 'Displays a list of departments';

    /**
     * @var array
     */
    private static $db = array(
        'Limit' => 'Int',
        'Order' => 'Varchar',
        'Direction' => 'Varchar',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Blog' => 'JobListingHolder',
    );

    /**
     * {@inheritdoc}
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields[] = DropdownField::create(
                'BlogID', _t('BlogDepartmentsWidget.Blog', Blog::class), Blog::get()->map()
            );

            $fields[] = NumericField::create(
                'Limit', _t('BlogDepartmentsWidget.Limit.Label', 'Limit'), 0
            )
                ->setDescription(_t('BlogDepartmentsWidget.Limit.Description', 'Limit the number of departments shown by this widget (set to 0 to show all departments).'))
                ->setMaxLength(3);

            $fields[] = DropdownField::create(
                'Order', _t('BlogDepartmentsWidget.Sort.Label', 'Sort'), array('Title' => 'Title', 'Created' => 'Created', 'LastEdited' => 'Updated')
            )
                ->setDescription(_t('BlogDepartmentsWidget.Sort.Description', 'Change the order of departments shown by this widget.'));

            $fields[] = DropdownField::create(
                'Direction', _t('BlogDepartmentsWidget.Direction.Label', 'Direction'), array('ASC' => 'Ascending', 'DESC' => 'Descending')
            )
                ->setDescription(_t('BlogDepartmentsWidget.Direction.Description', 'Change the direction of ordering of departments shown by this widget.'));
        });

        return parent::getCMSFields();
    }

    /**
     * @return DataList
     */
    public function getDepartments()
    {
        $blog = $this->Blog();

        if (!$blog) {
            return array();
        }

        $query = $blog->Departments();

        if ($this->Limit) {
            $query = $query->limit(Convert::raw2sql($this->Limit));
        }

        if ($this->Order && $this->Direction) {
            $query = $query->sort(Convert::raw2sql($this->Order), Convert::raw2sql($this->Direction));
        }

        return $query;
    }
}

