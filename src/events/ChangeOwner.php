<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://flipboxfactory.com/software/organization/license
 * @link       https://www.flipboxfactory.com/software/organization/
 */

namespace flipbox\organization\events;

use craft\elements\User;
use craft\events\CancelableEvent;
use flipbox\organization\elements\Organization;

/**
 * @package flipbox\organization\events
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class ChangeOwner extends CancelableEvent
{

    /**
     * @var Organization
     */
    public $organization;

    /**
     * @var User
     */
    public $fromOwner;

    /**
     * @var User
     */
    public $toOwner;

}