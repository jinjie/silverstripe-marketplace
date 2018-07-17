<?php

/**
 * ListingImageUploadField
 * 
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 * @package SwiftDevLabs\Marketplace\Form
 * @copyright 2018 Swift DevLabs
 */

namespace SwiftDevLabs\Marketplace\Form;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\SS_List;

class ListingImageUploadField extends UploadField
{
    public function __construct($name, $title = null, SS_List $items = null)
    {
        parent::__construct($name, $title, $items);

        $this->setFolderName('MarketPlace/ListingImages');
        $this->setAllowedFileCategories(['image']);

        return $this;
    }
}