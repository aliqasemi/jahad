<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted" => ":attribute باید پذیرفته شده باشد.",
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    "active_url" => "آدرس :attribute معتبر نیست",
    "after" => ":attribute باید تاریخی بعد از :date باشد.",
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    "alpha" => ":attribute باید شامل حروف الفبا باشد.",
    "alpha_dash" => ":attribute باید شامل حروف الفبا و عدد و خظ تیره(-) باشد.",
    "alpha_num" => ":attribute باید شامل حروف الفبا و عدد باشد.",
    "array" => ":attribute باید شامل آرایه باشد.",
    "before" => ":attribute باید تاریخی قبل از :date باشد.",
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    "between" => [
        "numeric" => ":attribute باید بین :min و :max باشد.",
        "file" => ":attribute باید بین :min و :max کیلوبایت باشد.",
        "string" => ":attribute باید بین :min و :max کاراکتر باشد.",
        "array" => ":attribute باید بین :min و :max آیتم باشد.",
    ],
    'boolean' => 'The :attribute field must be true or false.',
    "confirmed" => ":attribute با تاییدیه مطابقت ندارد.",
    'current_password' => 'The password is incorrect.',
    "date" => ":attribute یک تاریخ معتبر نیست.",
    'date_equals' => 'The :attribute must be a date equal to :date.',
    "date_format" => ":attribute با الگوی :format مطاقبت ندارد.",
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    "digits" => ":attribute باید :digits رقم باشد.",
    "digits_between" => ":attribute باید بین :min و :max رقم باشد.",
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    "email" => "فرمت :attribute معتبر نیست.",
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    "exists" => "این  :attribute  وجود دارد.",
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => ':attribute باید شامل عدد باشد.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        "numeric" => ":attribute نباید بزرگتر از :max باشد.",
        "file" => ":attribute نباید بزرگتر از :max کیلوبایت باشد.",
        "string" => ":attribute نباید بیشتر از :max کاراکتر باشد.",
        "array" => ":attribute نباید بیشتر از :max آیتم باشد.",
    ],
    'mimes' => ":attribute باید یکی از فرمت های :values باشد.",
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        "numeric" => ":attribute نباید کوچکتر از :min باشد.",
        "file" => ":attribute نباید کوچکتر از :min کیلوبایت باشد.",
        "string" => ":attribute نباید کمتر از :min کاراکتر باشد.",
        "array" => ":attribute نباید کمتر از :min آیتم باشد.",
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    "not_in" => ":attribute انتخاب شده، معتبر نیست.",
    'not_regex' => 'The :attribute format is invalid.',
    "numeric" => ":attribute باید شامل عدد باشد.",
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    "regex" => ":attribute یک فرمت معتبر نیست",
    "required" => "فیلد :attribute الزامی است",
    "required_if" => "فیلد :attribute هنگامی که :other برابر با :value است، الزامیست.",
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    "required_with" => ":attribute الزامی است زمانی که :values موجود است.",
    "required_with_all" => ":attribute الزامی است زمانی که :values موجود است.",
    "required_without" => ":attribute الزامی است زمانی که :values موجود نیست.",
    "required_without_all" => ":attribute الزامی است زمانی که :values موجود نیست.",
    "same" => ":attribute و :other باید مانند هم باشند.",
    'size' => [
        "numeric" => ":attribute باید برابر با :size باشد.",
        "file" => ":attribute باید برابر با :size کیلوبایت باشد.",
        "string" => ":attribute باید برابر با :size کاراکتر باشد.",
        "array" => ":attribute باسد شامل :size آیتم باشد.",
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => ':attribute باید شامل متن باشد.',
    "timezone" => ":attribute باید منطقه درست باشد.",
    "unique" => ":attribute قبلا انتخاب شده است.",
    'uploaded' => 'The :attribute failed to upload.',
    "url" => "فرمت آدرس :attribute اشتباه است.",
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'نام',
        'description' => 'توضیحات',
        'address' => 'آدرس',
        'postal_code' => 'کد پستی',
        'cell_number' => 'شماره تلفن',
        'phone_number' => 'شماره تلفن همراه',
        'city_id' => 'شهر',
        'parent_id' => 'دسته مادر',
        'branches' => 'شعب',
        'branch_id' => 'شعبه',
        'stock' => 'موجودی',
        'timeout' => 'زمان پایان',
        'services' => 'سرویس ها',
        'id' => 'شناسه',
        'requirement_id' => 'نیازمندی',
        'step_id' => 'مرحله',
        'require_products' => 'محصولات مورد نیاز',
        'number' => 'تعداد',
        'title' => 'عنوان',
        'category_id' => 'دسته بندی',
        'products' => 'محصولات',
        'product_id' => 'محصول',
        'available_province_ids' => 'شهر های در دسترس',
        'send_sms' => 'ارسال پیامکی',
        'service_template_id' => 'قالب سرویس',
        'requirement_template_id' => 'قالب نیازمندی',
        'project_id' => 'پروژه',
        'template' => 'قالب',
        'email' => 'ایمیل',
        'phoneNumber' => 'شماره تلفن',
        'password' => 'رمز عبور',
        'firstname' => 'نام',
        'lastname' => 'نام خانوادگی',
        'active' => 'فعال',
        'role' => 'نقش',
    ],

];
