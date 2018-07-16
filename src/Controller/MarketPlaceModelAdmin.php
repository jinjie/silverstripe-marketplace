<?php

/**
 * MarketPlaceModelAdmin
 *
 * @package SwiftDevLabs\MarketPlace\Controller
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MarketPlace\Controller;

use SilverStripe\Admin\ModelAdmin;
use SwiftDevLabs\MarketPlace\Model\Category;
use SwiftDevLabs\MarketPlace\Model\Listing;

class MarketPlaceModelAdmin extends ModelAdmin
{
    private static $managed_models = [
        Category::class,
        Listing::class,
    ];

    private static $url_segment = 'marketplace';

    private static $menu_title = 'Marketplace';
}