<?php
// Capabilities for block_gamification.


defined('MOODLE_INTERNAL') || die();


$capabilities = [
    'block/gamification:addinstance' => [
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
        'manager' => CAP_ALLOW,
        ],
        'clonepermissionsfrom' => 'moodle/my:manageblocks',
    ],


    'block/gamification:myaddinstance' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
        'user' => CAP_ALLOW,
        ],
        'clonepermissionsfrom' => 'moodle/my:manageblocks',
    ],


    'block/gamification:givexp' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
        'manager' => CAP_ALLOW,
        'teacher' => CAP_ALLOW,
        'editingteacher' => CAP_ALLOW,
        ],
    ],


    'block/gamification:export' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
        'manager' => CAP_ALLOW,
        'teacher' => CAP_ALLOW,
        'editingteacher' => CAP_ALLOW,
        ],
        'clonepermissionsfrom' => 'moodle/site:config',
    ],
];