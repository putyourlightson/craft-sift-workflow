# Sift Workflow Plugin for Craft CMS 3

Adds custom review processes to the Workflow plugin for specific categories.

## Requirements

Craft CMS 3.4.0 or later and Workflow 1.5.0 or later.

## Installation

Install the plugin using composer.

```
composer require putyourlightson/craft-sift-workflow
```

## Configuration

Copy the `src/config.php` config file to `craft/config` as `sift-workflow.php` and add a category group ID.
```php
return [
    '*' => [
        /**
         * The category group ID to use for custom review processes
         */
        'categoryGroupId' => 1,

        /**
         * The categories field handle to sift by
         */
        'categoriesFieldHandle' => 'userCategories',
    ],
];
```

## License

This plugin is licensed for free under the MIT License.

<small>Created by [PutYourLightsOn](https://putyourlightson.com/).</small>
