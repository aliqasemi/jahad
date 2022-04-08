<?php

return [
    'WELCOME' => [\App\Models\Template::$WELCOME => 'کاربر محترم {user_firstname} {user_lastname} به سامانه جهاد خوش آمدید'],
    'SING_IN ' => [\App\Models\Template::$SING_IN => 'کاربر محترم {user_firstname} {user_lastname} شما کد اهراز هویت شما : {confirm_code}'],
    'RESET_PASSWORD' => [\App\Models\Template::$RESET_PASSWORD => 'کابر محترم{user_firstname} {user_lastname} کد تایید برای تغییر رمز شما : {confirm_code}'],
    'PASSWORD_CHANGE' => [\App\Models\Template::$PASSWORD_CHANGE => 'کابر محترم {user_firstname} {user_lastname} رمز شما با موفقیت تغییر کرد'],
    'SERVICES_REQUIREMENT' => [\App\Models\Template::$SERVICES_REQUIREMENT => 'کاربر گرامی {user_firstname} {user_lastname} برای مشاهده سرویس های ارایه شده جهاد سازندگی برای نیازمندی شما پنل خود را چک بفرمایید'],
    'REQUIREMENTS_SERVICE' => [\App\Models\Template::$REQUIREMENTS_SERVICE => 'کاربر گرامی {user_firstname} {user_lastname} برای مشاهده نیاز های ارایه شده جهاد سازندگی برای سرویس شما پنل خود را چک بفرمایید'],
];
