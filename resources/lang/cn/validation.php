<?php

return [
    'required' => ':attribute 是必填的。',
    'email' => ':attribute 必须是一个有效的电子邮件地址。',
    'date' => ':attribute 必须是有效的日期。',
    'date_format' => ':attribute 必须具有有效的时间格式。',
    'max' => [
        'string' => ':attribute 不能超过 :max 个字符。',
    ],
    'min' => [
        'string' => ':attribute 必须至少 :min 个字符。',
    ],
    'integer' => ':attribute 必须是一个整数。',
    'guests.*.service_option_id.exists' => ':attribute 的服务不存在。',
    'attributes' => [
        'name' => '客户姓名',
        'email' => '电子邮件',
        'phone' => '电话号码',
        'date' => '日期',
        'time' => '时间',
        'guestCount' => '客人数',
        'guests' => '客人列表',
        'guest_name' => '客人姓名',
        'content'=>'内容'
    ],
];
