<?php

/**
 * ManageListingsPageController.php
 *
 * @package  SwiftDevLabs\Marketplace\Controller
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 * @copyright 2018 Swift DevLabs
 */

namespace SwiftDevLabs\Marketplace\Controller;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;
use SwiftDevLabs\MarketPlace\Model\Listing;
use SwiftDevLabs\Marketplace\Form\ListingForm;

class ManageListingsPageController extends \PageController
{
    private static $allowed_actions = [
        'post',
        'PostListingForm',
        'edit',
        'EditListingForm',
    ];

    private static $url_handlers = [
    ];

    public function init()
    {
        if (! Security::getCurrentUser())
        {
            Security::permissionFailure('Please login to access this section.');
        }

        parent::init();
    }

    public function index()
    {
        return $this->customise([
            'Listings'  => Security::getCurrentUser()->Listings(),
        ]);
    }

    public function post()
    {
        return $this->customise([
            'Title' => 'Post a Listing',
            'Form'  => $this->PostListingForm(),
        ]);
    }

    public function edit(HTTPRequest $request)
    {
        $listing = Listing::get()->filter([
            'ID'        => $request->param('ID'),
            'SellerID'  => Security::getCurrentUser()->ID,
        ])->first();

        if (! $listing)
        {
            return $this->httpError(404);
        }

        $form = $this->EditListingForm();
        $form->loadDataFrom($listing);

        return $this->customise([
            'Title' => "Edit \"{$listing->Title}\"",
            'Form'  => $form,
        ]);
    }

    public function EditListingForm()
    {
        return ListingForm::create($this, 'EditListingForm');
    }

    public function PostListingForm()
    {
        return ListingForm::create($this, 'PostListingForm');
    }
}