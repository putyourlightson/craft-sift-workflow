<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\siftworkflow;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\web\Controller;
use craft\web\UrlManager;
use putyourlightson\siftworkflow\models\SettingsModel;
use verbb\workflow\events\ReviewerUserGroupsEvent;
use verbb\workflow\services\Submissions;
use yii\base\Event;

/**
 * Sift Workflow plugin
 *
 * @property SettingsModel $settings
 */
class SiftWorkflow extends Plugin
{
    /**
     * @var SiftWorkflow
     */
    public static $plugin;

    /**
     * @inherit
     */
    public $hasCpSettings = true;

    public function init()
    {
        parent::init();

        self::$plugin = $this;

        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
                $event->rules['settings/plugins/sift-workflow/<categoryId:\d+>'] = 'sift-workflow/settings/edit-category';
            }
        );

        Event::on(Submissions::class, Submissions::EVENT_AFTER_GET_REVIEWER_USER_GROUPS,
            function (ReviewerUserGroupsEvent $event) {
                $event->userGroups = [];
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function getSettingsResponse()
    {
        /** @var Controller $controller */
        $controller = Craft::$app->controller;

        return $controller->renderTemplate('sift-workflow/_settings/index', [
            'settings' => $this->settings,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): SettingsModel
    {
        return new SettingsModel();
    }
}
