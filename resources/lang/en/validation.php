<?php

return [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'date' => 'The :attribute must be a valid date.',
    'date_format' => 'The :attribute must have a valid time format.',
    'max' => [
        'string' => 'The :attribute may not be greater than :max characters.',
    ],
    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'integer' => 'The :attribute must be an integer.',
    'guests.*.service_option_id.exists' => 'The service does not exist for guest :attribute.',
    'attributes' => [
        'name' => 'Customer Name',
        'email' => 'Email',
        'phone' => 'Phone Number',
        'date' => 'Date',
        'time' => 'Time',
        'guestCount' => 'Guest Count',
        'guests' => 'Guest List',
        'guest_name' => 'Guest Name',
        'content'=>'Content'
    ],
];
