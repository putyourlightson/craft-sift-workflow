<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\siftworkflow\controllers;

use Craft;
use craft\elements\Category;
use craft\web\Controller;
use putyourlightson\restaurantmanager\models\TableModel;
use putyourlightson\restaurantmanager\RestaurantManager;
use putyourlightson\siftworkflow\SiftWorkflow;
use Throwable;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SettingsController extends Controller
{
    /**
     * @param int $categoryId
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionEditCategory(int $categoryId): Response
    {
        $category = Category::findOne($categoryId);

        $userGroups = SiftWorkflow::$plugin->settings->categoryReviewUserGroups[$categoryId] ?? [];

        $variables = [
            'category' => $category,
            'categoryReviewUserGroups' => $userGroups,
        ];

        // Full page form variables
        $variables['fullPageForm'] = true;

        // Render the template
        return $this->renderTemplate('sift-workflow/_settings/edit', $variables);
    }

    /**
     * @return Response|null
     * @throws Throwable
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionSaveCategory()
    {
        $this->requirePostRequest();

        $request = Craft::$app->getRequest();

        $categoryId = $request->getBodyParam('categoryId');
        $categoryReviewUserGroups = $request->getBodyParam('categoryReviewUserGroups');

        $settings = SiftWorkflow::$plugin->settings;

        $settings->categoryReviewUserGroups[$categoryId] = $categoryReviewUserGroups;

        Craft::$app->getPlugins()->savePluginSettings(SiftWorkflow::$plugin, $settings->getAttributes());

        Craft::$app->getSession()->setNotice('Review user groups saved.');

        return $this->redirectToPostedUrl();
    }

    /**
     * Deletes a table
     *
     * @return Response
     * @throws BadRequestHttpException
     * @throws Throwable
     */
    public function actionDeleteCategory(): Response
    {
        $this->requirePostRequest();

        $categoryId = Craft::$app->getRequest()->getBodyParam('categoryId');

        $settings = SiftWorkflow::$plugin->settings;

        if (isset($settings->categoryReviewUserGroups[$categoryId])) {
            unset($settings->categoryReviewUserGroups[$categoryId]);

            Craft::$app->getPlugins()->savePluginSettings(SiftWorkflow::$plugin, $settings->getAttributes());
        }

        Craft::$app->getSession()->setNotice('Review user groups deleted.');

        return $this->redirectToPostedUrl();
    }
}
