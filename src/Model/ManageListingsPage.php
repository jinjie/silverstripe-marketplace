<?php

/**
 * ManageListingsPage
 *
 * @package SwiftDevLabs\Marketplace\Model
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\Marketplace\Model;

use SilverStripe\Security\Security;
use SwiftDevLabs\Marketplace\Controller\ManageListingsPageController;

class ManageListingsPage extends \Page
{
    private static $description = 'Create a marketplace listing management page';

    public function getControllerName()
    {
        return ManageListingsPageController::class;
    }

    public function getPostListingLink()
    {
        return $this->Link('post');
    }
}