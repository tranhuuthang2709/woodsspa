<?php

return [
    'required' => ':attribute 필드는 필수입니다.',
    'email' => ':attribute 는 유효한 이메일 주소여야 합니다.',
    'date' => ':attribute 는 유효한 날짜여야 합니다.',
    'date_format' => ':attribute 는 유효한 시간 형식을 가져야 합니다.',
    'max' => [
        'string' => ':attribute 는 :max 자리를 초과할 수 없습니다.',
    ],
    'min' => [
        'string' => ':attribute 는 최소한 :min 자 이상이어야 합니다.',
    ],
    'integer' => ':attribute 는 정수여야 합니다.',
    'guests.*.service_option_id.exists' => ':attribute 의 서비스는 존재하지 않습니다.',
    'attributes' => [
        'name' => '고객 이름',
        'email' => '이메일',
        'phone' => '전화번호',
        'date' => '날짜',
        'time' => '시간',
        'guestCount' => '손님 수',
        'guests' => '손님 목록',
        'guest_name' => '손님 이름',
        'content'=>'내용',
    ],
];
