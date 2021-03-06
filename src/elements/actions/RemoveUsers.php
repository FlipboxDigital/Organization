<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://flipboxfactory.com/software/organization/license
 * @link       https://www.flipboxfactory.com/software/organization/
 */

namespace flipbox\organization\elements\actions;

use Craft;
use craft\base\ElementAction;
use craft\elements\db\ElementQueryInterface;
use craft\elements\User;
use flipbox\organization\elements\Organization;
use flipbox\organization\Organization as OrganizationPlugin;
use yii\base\Exception;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class RemoveUsers extends ElementAction
{

    /**
     * @var string|int|array|Organization
     */
    public $organization;

    /**
     * @return array
     */
    public function settingsAttributes(): array
    {
        return array_merge(
            parent::settingsAttributes(),
            [
                'organization'
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function isDestructive(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getTriggerLabel(): string
    {
        return 'Remove';
    }

    /**
     * @inheritdoc
     */
    public function performAction(ElementQueryInterface $query): bool
    {

        if (empty($this->organization)) {
            throw new Exception("Organization does not exist with the identifier “{$this->organization}”");
        }

        /** @var Organization $organization */
        $organization = OrganizationPlugin::getInstance()->getOrganization()->get($this->organization);

        /** @var User $user */
        foreach ($query->all() as $user) {
            if (!OrganizationPlugin::getInstance()->getUser()->dissociate($user, $organization)) {
                throw new Exception(
                    Craft::t(
                        'organization',
                        "Unable to disassociate user “{user}” from organization “{organization}”",
                        [
                            '{user}' => $user->getId(),
                            '{organization}' => $organization->getId()
                        ]
                    )
                );
            }
        }

        $this->setMessage(
            Craft::t(
                'organization',
                'User' . ($query->count() != 1 ? 's' : '') . ' removed.'
            )
        );

        return true;
    }
}
