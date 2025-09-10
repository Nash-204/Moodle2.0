<?php
// file: blocks/gamification/db/messages.php
defined('MOODLE_INTERNAL') || die();

$messageproviders = [
    'xpnotification' => [
        'defaults' => [
            'popup' => MESSAGE_PERMITTED, // enables by default
            'email' => MESSAGE_PERMITTED, // allows email, but users can disable
        ],
    ],
];
