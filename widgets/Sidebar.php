<?php

namespace humhub\modules\mostactiveusers\widgets;

use humhub\models\Setting;
use humhub\modules\mostactiveusers\models\ActiveUser;

class Sidebar extends \humhub\components\Widget
{

    public function run()
    {
        $users = ActiveUser::find()->limit((int) Setting::Get('noUsers', 'mostactiveusers'))->all();
        if (count($users) == 0) {
            return;
        }

        return $this->render('sidebar', array(
                    'users' => $users
        ));
    }

}

?>
