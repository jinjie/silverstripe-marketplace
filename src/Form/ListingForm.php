<?php

/**
 * ListingForm.php
 * 
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 * @package  SwiftDevLabs\Marketplace\Form
 * @copyright 2018 Swift DevLabs
 */

namespace SwiftDevLabs\Marketplace\Form;

use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileHandleField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\ValidationResult;
use SwiftDevLabs\MarketPlace\Model\Category;
use SwiftDevLabs\MarketPlace\Model\Listing;

class ListingForm extends Form
{
    public function __construct($controller, $name)
    {
        $fields = FieldList::create();

        $fields->push(TextField::create('Title', 'Title'));

        $fields->push(TextField::create('Price', 'Price'));

        $fields->push(DropdownField::create('CategoryID', 'Select a category', Category::get()->map('ID', 'Title'))
            ->setEmptyString('-')
        );

        $fields->push(TextareaField::create('Description', 'Item Description'));

        /**
         * @todo Upload Images
         */

        $fields->push(HiddenField::create('ID'));

        $actions = FieldList::create();

        $actions->push(FormAction::create('doSaveDraft', 'Save As Draft'));
        $actions->push(FormAction::create('doSavePublish', 'Save & Publish'));

        parent::__construct($controller, $name, $fields, $actions);

        return $this;
    }

    public function doSaveDraft($data, $form)
    {
        if (! $data['ID'] OR ! $listing = Listing::get()->filter('ID', $data['ID'])->First() OR ! $listing->getIsMine())
        {
            $listing = Listing::create();
        }

        $form->saveInto($listing);

        if ($listing->saveDraft())
        {
            $form->sessionMessage("Item \"{$listing->Title}\" saved as Draft", ValidationResult::TYPE_GOOD);

            return $this->getController()->redirectBack();
        }
    }

    public function doSavePublish($data, $form)
    {
        if (! $data['ID'] OR ! $listing = Listing::get()->filter('ID', $data['ID'])->First() OR ! $listing->getIsMine())
        {
            $listing = Listing::create();
        }

        $form->saveInto($listing);

        if ($listing->publish())
        {
            $form->sessionMessage("Item \"{$listing->Title}\" saved and published", ValidationResult::TYPE_GOOD);

            return $this->getController()->redirectBack();
        }
    }
}