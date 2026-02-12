<?php

return [
    'required' => ':attribute は必須です。',
    'email' => ':attribute は有効なメールアドレスでなければなりません。',
    'date' => ':attribute は有効な日付でなければなりません。',
    'date_format' => ':attribute は有効な時間形式でなければなりません。',
    'max' => [
        'string' => ':attribute は :max 文字を超えてはいけません。',
    ],
    'min' => [
        'string' => ':attribute は少なくとも :min 文字以上でなければなりません。',
    ],
    'integer' => ':attribute は整数でなければなりません。',
    'guests.*.service_option_id.exists' => ':attribute のサービスは存在しません。',
    'attributes' => [
        'name' => '顧客名',
        'email' => 'メールアドレス',
        'phone' => '電話番号',
        'date' => '日付',
        'time' => '時間',
        'guestCount' => 'ゲスト数',
        'guests' => 'ゲストリスト',
        'guest_name' => 'ゲスト名',
        'content'=>'内容',
    ],
];
