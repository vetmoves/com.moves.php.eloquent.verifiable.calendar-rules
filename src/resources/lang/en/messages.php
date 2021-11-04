<?php

return [
    'config' => [
        'event' => [
            'start_end_time' => 'Event start time must be before event end time.'
        ],
        'rule' => [
            'start_end_time' => 'Rule start time must be before rule end time.',
            'open_close_time' => 'Rule open time must be before rule close time.'
        ]
    ],

    'advance' => [
        'min' => 'This event must be booked at least :expected in advance.',
        'max' => 'This event must be booked less than :expected in advance.'
    ],
    'unavailable' => 'This event cannot be booked between :unavailable_start and :unavailable_end.',
    'cutoff' => [
        'allow' => 'This event cannot be booked until :cutoff_time.',
        'disallow' => 'Booking for this event closed at :cutoff_time.'
    ],
    'max_attendees' => 'This event cannot have more than :expected attendees.',
    'max_duration' => 'This event cannot be longer than :expected.',
    'open_close' => 'This event must be booked during the open hours :open_time - :close_time.',
    'windows' => 'This event must be booked during one of the pre-configured availability windows.'
];
