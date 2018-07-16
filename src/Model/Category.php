<?php

/**
 * Category
 *
 * @package SwiftDevLabs\MarketPlace\Model
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MarketPlace\Model;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\Hierarchy\Hierarchy;
use SilverStripe\View\HTML;
use SwiftDevLabs\MarketPlace\Model\Category;
use SwiftDevLabs\MarketPlace\Model\Listing;

class Category extends DataObject
{
    private static $table_name = 'Category';
    
    private static $db = [
        'Title'       => 'Varchar(200)',
        'Description' => 'Text',
    ];

    private static $has_many = [
        'Listings'  => Listing::class,
    ];

    private static $summary_fields = [
        'Title',
        'GridFieldBreadcrumbs'  => 'Breadcrumbs',
        'Listings.Count'        => 'Listings Count',    
    ];

    private static $cascade_deletes = [
        'Listings',
    ];

    private static $extensions = [
        Hierarchy::class,
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
    
        $fields->removeByName('ParentID');

        $tree = TreeDropdownField::create('ParentID', "Parent Category", Category::class)
            ->setEmptyString('Top Level');

        $fields->fieldByName('Root.Main')
            ->push($tree);

        if ($this->isInDB())
        {
            $listingsField = $fields->fieldByName('Root.Listings.Listings');
            $listingsField->setConfig(GridFieldConfig_RecordEditor::create());
        }
    
        return $fields;
    }

    public function getAllListings()
    {
        /**
         * @todo Return all listings under this category and it's children
         */
    }

    public function getValitron()
    {
        $v = new \Valitron\Validator([
            'Title'       => $this->Title,
            'Description' => $this->Description,
        ]);

        $v->rule('required', [
            'Title',
            'Description',
        ]);

        return $v;
    }

    public function getGridFieldBreadcrumbs()
    {
        if ($this->ParentID)
        {
            return DBField::create_field('HTMLText', parent::getBreadcrumbs(" &#9656; "));
        }

        return "Top Level";
    }
}