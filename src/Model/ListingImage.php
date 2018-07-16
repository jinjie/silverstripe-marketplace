<?php

/**
 * ListingImage
 *
 * @package SwiftDevLabs\MarketPlace\Model
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 */

namespace SwiftDevLabs\MarketPlace\Model;

use SilverStripe\Assets\Image;
use SwiftDevLabs\MarketPlace\Model\Listing;

class ListingImage extends Image
{
    private static $table_name = 'ListingImage';

    private static $db = [];

    private static $has_one = [
        'Listing'   => Listing::class,
    ];

    private static $has_many = [];
}