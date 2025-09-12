<?php
// Event observers for block_gamification.

defined('MOODLE_INTERNAL') || die();

$observers = [

    // Course completed.
    [
        'eventname' => '\\core\\event\\course_completed',
        'callback'  => '\\block_gamification\\observer::course_completed',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Daily login.
    [
        'eventname' => '\\core\\event\\user_loggedin',
        'callback'  => '\\block_gamification\\observer::user_loggedin',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Profile update.
    [
        'eventname' => '\\core\\event\\user_updated',
        'callback'  => '\\block_gamification\\observer::profile_updated',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Course view.
    [
        'eventname' => '\\core\\event\\course_viewed',
        'callback'  => '\\block_gamification\\observer::course_viewed',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Quiz.
    [
        'eventname' => '\\mod_quiz\\event\\attempt_submitted',
        'callback'  => '\\block_gamification\\observer::quiz_attempt_submitted',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Forum.
    [
        'eventname' => '\\mod_forum\\event\\discussion_created',
        'callback'  => '\\block_gamification\\observer::forum_discussion_created',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Forum post.
    [
        'eventname' => '\\mod_forum\\event\\post_created',
        'callback'  => '\\block_gamification\\observer::forum_post_created',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Assignment.
    [
        'eventname' => '\\mod_assign\\event\\assessable_submitted',
        'callback'  => '\\block_gamification\\observer::assignment_submitted',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Lesson.
    [
        'eventname' => '\\mod_lesson\\event\\lesson_completed',
        'callback'  => '\\block_gamification\\observer::lesson_completed',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Workshop.
    [
        'eventname' => '\\mod_workshop\\event\\assessment_evaluated',
        'callback'  => '\\block_gamification\\observer::workshop_assessed',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Glossary.
    [
        'eventname' => '\\mod_glossary\\event\\entry_created',
        'callback'  => '\\block_gamification\\observer::glossary_entry_created',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Database activity.
    [
        'eventname' => '\\mod_data\\event\\record_created',
        'callback'  => '\\block_gamification\\observer::data_record_created',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Wiki.
    [
        'eventname' => '\\mod_wiki\\event\\page_created',
        'callback'  => '\\block_gamification\\observer::wiki_page_created',
        'priority'  => 1000,
        'internal'  => false,
    ],
    
    // Wiki update.
    [
        'eventname' => '\\mod_wiki\\event\\page_updated',
        'callback'  => '\\block_gamification\\observer::wiki_page_updated',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Resource view.
    [
        'eventname' => '\\mod_resource\\event\\course_module_viewed',
        'callback'  => '\\block_gamification\\observer::resource_viewed',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Feedback submitted.
    [
        'eventname' => '\\mod_feedback\\event\\response_submitted',
        'callback'  => '\\block_gamification\\observer::feedback_submitted',
        'priority'  => 1000,
        'internal'  => false,
    ],

    // Choice answered.
    [
        'eventname' => '\\mod_choice\\event\\answer_submitted',
        'callback'  => '\\block_gamification\\observer::choice_answered',
        'priority'  => 1000,
        'internal'  => false,
    ],
];
