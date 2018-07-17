<?php

/**
 * Listing
 *
 * @package SwiftDevLabs\MarketPlace\Model
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MarketPlace\Model;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Control\Director;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SwiftDevLabs\MarketPlace\Model\Category;
use SwiftDevLabs\MarketPlace\Model\ListingImage;
use SwiftDevLabs\Marketplace\Form\ListingImageUploadField;

class Listing extends DataObject
{
    private static $table_name = 'Listing';

    private static $db = [
        'Title'       => 'Varchar(200)',
        'Price'       => 'Currency',
        'Description' => 'Text',
        'Status'      => 'Enum(array("Draft", "Live"))',
    ];

    private static $has_one = [
        'Category'  => Category::class,
        'Seller'    => Member::class,
    ];

    private static $has_many = [
        'Images'    => ListingImage::class,
    ];

    private static $summary_fields = [
        'Title',
        'Description.Summary'           => 'Summary',
        'Category.GridFieldBreadcrumbs' => 'Category',
        'Seller.Name'                   => 'Seller',
        'Status'                        => 'Status',
    ];

    private static $owns = [
        'Images',
    ];

    private static $cascade_deletes = [
        'Images',
    ];

    private static $default_sort = 'Created DESC';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Images');

        $uploadField = UploadField::create('Images', 'Upload Images')
            ->setFolderName('MarketPlace/ListingImages');

        $fields->addFieldToTab('Root.Main', $uploadField, 'CategoryID');

        $fields->removeByName('CategoryID');
        $fields->addFieldToTab('Root.Main', TreeDropdownField::create('CategoryID', 'Select a category', Category::class), 'SellerID');
    
        return $fields;
    }

    public function saveDraft()
    {
        $this->Status = 'Draft';
        return $this->write();
    }

    public function publish()
    {
        $this->Status = 'Live';
        return $this->write();
    }

    public function getLink()
    {
        return "listing/view/{$this->ID}";
    }

    public function getEditLink()
    {
        // Find ManageListingsPage
        $page = ManageListingsPage::get()->first();

        if ($page)
        {
            return "{$page->Link()}edit/{$this->ID}";
        }

        return FALSE;
    }

    public function getIsMine()
    {
        if (! $member = Security::getCurrentUser())
        {
            return FALSE;
        }

        return ($member->ID == $this->SellerID);
    }

    public function getAbsoluteLink()
    {
        return Director::absoluteURL($this->getLink());
    }

    public function populateDefaults()
    {
        if ($member = Security::getCurrentUser())
        {
            $this->SellerID = $member->ID;
        }
    }

    public function getValitron()
    {
        $v = new \Valitron\Validator([
            'Title'       => $this->Title,
            'Description' => $this->Description,
            'Price'       => $this->Price,
            'CategoryID'  => $this->CategoryID,
            'SellerID'    => $this->SellerID,
        ]);

        $v->rule('required', [
            'Title',
            'Description',
            'Price',
            'CategoryID',
            'SellerID',
        ]);

        $v->labels([
            'CategoryID' => 'Category',
            'SellerID'   => 'Seller',
        ]);

        return $v;
    }
}