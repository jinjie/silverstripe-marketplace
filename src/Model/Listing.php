<?php

/**
 * Listing
 *
 * @package SwiftDevLabs\MarketPlace\Model
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MarketPlace\Model;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\Versioned\Versioned;
use SwiftDevLabs\MarketPlace\Model\Category;
use SwiftDevLabs\MarketPlace\Model\ListingImage;

class Listing extends DataObject
{
    private static $table_name = 'Listing';

    private static $db = [
        'Title'       => 'Varchar(200)',
        'Description' => 'Text',
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
    ];

    private static $extensions = [
        Versioned::class,
    ];

    private static $owns = [
        'Images',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Images');

        $uploadField = UploadField::create('Images', 'Upload Images')
            ->setFolderName('MarketPlace/ListingImages');

        $fields->addFieldToTab('Root.Main', $uploadField, 'CategoryID');
    
        return $fields;
    }

    public function onAfterUnpublish()
    {
        /**
         * Unpublish images after listing is unpublished
         */
        foreach ($this->Images() as $image)
        {
            $image->doUnpublish();
        }
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
            'CategoryID'  => $this->CategoryID,
            'SellerID'    => $this->SellerID,
        ]);

        $v->rule('required', [
            'Title',
            'Description',
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