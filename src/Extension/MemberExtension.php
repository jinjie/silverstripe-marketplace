<?php

/**
 * MemberExtension.php
 * 
 * @author Kong Jin Jie <jinjie@swiftdev.sg>
 * @copyright 2018 Swift DevLabs
 * @package SwiftDevLabs\MarketPlace\Extension
 */

namespace SwiftDevLabs\MarketPlace\Extension;

use SilverStripe\ORM\DataExtension;
use SwiftDevLabs\MarketPlace\Model\Listing;

class MemberExtension extends DataExtension
{
    private static $has_many = [
        'Listings'  => Listing::class,
    ];

    private static $owns = [
        'Listings',
    ];
}