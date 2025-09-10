<?php
namespace block_gamification;

defined('MOODLE_INTERNAL') || die();

/**
 * Event observer callbacks for awarding XP.
 *
 * @package   block_gamification
 */
class observer {

    /**
     * Award XP and notify the user.
     */
    private static function award_xp_and_notify(int $userid, int $points, string $reason) {
        global $USER;

        if ($points <= 0) {
            return;
        }

        $manager = new leaderboard_manager();
        $manager->add_xp($userid, $points);

        // Toast notification (only visible if current user = xp earner).
        if ($USER->id === $userid) {
            \core\notification::success(get_string('xpearnedsmall', 'block_gamification', [
                'points' => $points,
                'reason' => $reason
            ]));
        }

        // ✅ Send Moodle notification (stored in notification drawer).
        $eventdata = new \core\message\message();
        $eventdata->component         = 'block_gamification';
        $eventdata->name              = 'xpnotification';
        $eventdata->userfrom          = \core_user::get_noreply_user();
        $eventdata->userto            = $userid;
        $eventdata->subject           = get_string('xpearnedsubject', 'block_gamification');
        $eventdata->fullmessage       = get_string('xpearnedfull', 'block_gamification', [
            'points' => $points,
            'reason' => $reason
        ]);
        $eventdata->fullmessageformat = FORMAT_MARKDOWN;
        $eventdata->fullmessagehtml   = "<p>🎉 You earned <strong>{$points} XP</strong> for {$reason}.</p>";
        $eventdata->smallmessage      = get_string('xpearnedsmall', 'block_gamification', [
            'points' => $points,
            'reason' => $reason
        ]);
        $eventdata->notification      = 1;
        message_send($eventdata);

        // Keep storing a toast preference for frontend JS display.
        set_user_preference('block_gamification_toast',
            get_string('xpearnedsmall', 'block_gamification', [
                'points' => $points,
                'reason' => $reason
            ]),
            $userid
        );
    }


    // === Event handlers ===

    public static function quiz_attempt_submitted(\mod_quiz\event\attempt_submitted $event): void {
        $points = (int)(get_config('block_gamification', 'xp_quizpass') ?? 50);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_quiz', 'block_gamification'));
    }

    public static function course_completed(\core\event\course_completed $event): void {
        $points = (int)(get_config('block_gamification', 'xp_coursecompleted') ?? 100);
        self::award_xp_and_notify($event->relateduserid, $points, get_string('reason_course', 'block_gamification'));
    }

    public static function user_loggedin(\core\event\user_loggedin $event): void {
        $userid = $event->userid;
        $today = date('Y-m-d');
        $lastlog = get_user_preferences('block_gamification_lastlogin', '', $userid);

        if ($lastlog !== $today) {
            $points = (int)(get_config('block_gamification', 'xp_dailylogin') ?? 5);
            self::award_xp_and_notify($userid, $points, get_string('reason_daily', 'block_gamification'));
            set_user_preference('block_gamification_lastlogin', $today, $userid);
        }
    }

    public static function forum_discussion_created(\mod_forum\event\discussion_created $event): void {
        $points = (int)(get_config('block_gamification', 'xp_forumdiscussion') ?? 10);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_forum_discussion', 'block_gamification'));
    }

    public static function forum_post_created(\mod_forum\event\post_created $event): void {
        $points = (int)(get_config('block_gamification', 'xp_forumpost') ?? 5);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_forum_post', 'block_gamification'));
    }

    public static function assignment_submitted(\mod_assign\event\assessable_submitted $event): void {
        $points = (int)(get_config('block_gamification', 'xp_assignment') ?? 20);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_assignment', 'block_gamification'));
    }

    public static function profile_updated(\core\event\user_updated $event): void {
        $user = \core_user::get_user($event->userid);
        if (!empty($user->picture)) {
            $points = (int)(get_config('block_gamification', 'xp_profilepic') ?? 15);
            self::award_xp_and_notify($event->userid, $points, get_string('reason_profilepic', 'block_gamification'));
        }
    }

    public static function lesson_completed(\mod_lesson\event\lesson_completed $event): void {
        $points = (int)(get_config('block_gamification', 'xp_lesson') ?? 25);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_lesson', 'block_gamification'));
    }

    public static function workshop_assessed(\mod_workshop\event\assessment_evaluated $event): void {
        $points = (int)(get_config('block_gamification', 'xp_peerassessment') ?? 20);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_workshop', 'block_gamification'));
    }

    public static function glossary_entry_created(\mod_glossary\event\entry_created $event): void {
        $points = (int)(get_config('block_gamification', 'xp_glossary') ?? 10);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_glossary', 'block_gamification'));
    }

    public static function data_record_created(\mod_data\event\record_created $event): void {
        $points = (int)(get_config('block_gamification', 'xp_database') ?? 10);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_database', 'block_gamification'));
    }

    public static function wiki_page_created(\mod_wiki\event\page_created $event): void {
        $points = (int)(get_config('block_gamification', 'xp_wiki') ?? 15);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_wiki_create', 'block_gamification'));
    }

    public static function wiki_page_updated(\mod_wiki\event\page_updated $event): void {
        $points = (int)(get_config('block_gamification', 'xp_wikiupdate') ?? 8);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_wiki_update', 'block_gamification'));
    }
}
