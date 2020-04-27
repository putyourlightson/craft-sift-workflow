<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\siftworkflow\models;

use craft\base\Model;

class SettingsModel extends Model
{
    /**
     * @var int|null
     */
    public $categoryGroupId;

    /**
     * @var array
     */
    public $categoryReviewUserGroups = [];
}
