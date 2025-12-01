<?php

namespace humhub\modules\mostactiveusers\widgets;

use humhub\modules\mostactiveusers\models\ActiveUser;
use humhub\modules\mostactiveusers\models\ConfigureForm;

class Sidebar extends \humhub\components\Widget
{
    public function run()
    {
        $users = ActiveUser::find()->limit((int) (new ConfigureForm())->noUsers)->all();
        if (count($users) == 0) {
            return '';
        }

        return $this->render('sidebar', [
            'users' => $users,
        ]);
    }

}
