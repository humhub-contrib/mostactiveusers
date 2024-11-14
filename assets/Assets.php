<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\mostactiveusers\assets;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@mostactiveusers/resources';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/mostactiveusers.css',
    ];
}