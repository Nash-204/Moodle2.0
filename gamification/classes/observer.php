<?php
namespace block_gamification;

defined('MOODLE_INTERNAL') || die();

/**
 * Event observer callbacks for awarding XP.
 *
 * @package   block_gamification
 */
class observer {

    // Award XP and notify the user.
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

        // Send Moodle notification (stored in notification drawer).
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

        // Add "Go to: Dashboard" link
        $eventdata->contexturl = (new \moodle_url('/my'))->out(false);
        $eventdata->contexturlname = get_string('myhome');

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
    // Quiz attempt submitted (check if passed).
    public static function quiz_attempt_submitted(\mod_quiz\event\attempt_submitted $event): void {
        if (!get_config('block_gamification', 'enable_quizpass')) return;
        $points = (int)(get_config('block_gamification', 'xp_quizpass') ?? 50);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_quiz', 'block_gamification'));
    }

    // Course completed.
    public static function course_completed(\core\event\course_completed $event): void {
        if (!get_config('block_gamification', 'enable_coursecompleted')) return;
        $points = (int)(get_config('block_gamification', 'xp_coursecompleted') ?? 100);
        self::award_xp_and_notify($event->relateduserid, $points, get_string('reason_course', 'block_gamification'));
    }

    // Daily login.
    public static function user_loggedin(\core\event\user_loggedin $event): void {
        if (!get_config('block_gamification', 'enable_dailylogin')) return;
        $userid = $event->userid;
        $today = date('Y-m-d');
        $lastlog = get_user_preferences('block_gamification_lastlogin', '', $userid);

        if ($lastlog !== $today) {
            $points = (int)(get_config('block_gamification', 'xp_dailylogin') ?? 5);
            self::award_xp_and_notify($userid, $points, get_string('reason_daily', 'block_gamification'));
            set_user_preference('block_gamification_lastlogin', $today, $userid);
        }
    }

    // Course viewed.
    public static function course_viewed(\core\event\course_viewed $event): void {
        if (!get_config('block_gamification', 'enable_courseview')) return;
        $points = (int)(get_config('block_gamification', 'xp_courseview') ?? 2);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_courseview', 'block_gamification'));
    }

    // Forum discussion created.
    public static function forum_discussion_created(\mod_forum\event\discussion_created $event): void {
        if (!get_config('block_gamification', 'enable_forumdiscussion')) return;
        $points = (int)(get_config('block_gamification', 'xp_forumdiscussion') ?? 10);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_forum_discussion', 'block_gamification'));
    }

    // Forum post created.
    public static function forum_post_created(\mod_forum\event\post_created $event): void {
        if (!get_config('block_gamification', 'enable_forumpost')) return;
        $points = (int)(get_config('block_gamification', 'xp_forumpost') ?? 5);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_forum_post', 'block_gamification'));
    }

    // Assignment submitted.
    public static function assignment_submitted(\mod_assign\event\assessable_submitted $event): void {
        if (!get_config('block_gamification', 'enable_assignment')) return;
        $points = (int)(get_config('block_gamification', 'xp_assignment') ?? 20);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_assignment', 'block_gamification'));
    }

    // Profile updated (check if picture changed).
    public static function profile_updated(\core\event\user_updated $event): void {
        if (!get_config('block_gamification', 'enable_profilepic')) return;
        $user = \core_user::get_user($event->userid);
        if (!empty($user->picture)) {
            $points = (int)(get_config('block_gamification', 'xp_profilepic') ?? 15);
            self::award_xp_and_notify($event->userid, $points, get_string('reason_profilepic', 'block_gamification'));
        }
    }

    // Lesson completed.
    public static function lesson_completed(\mod_lesson\event\lesson_completed $event): void {
        if (!get_config('block_gamification', 'enable_lesson')) return;
        $points = (int)(get_config('block_gamification', 'xp_lesson') ?? 25);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_lesson', 'block_gamification'));
    }

    // Workshop assessed.
    public static function workshop_assessed(\mod_workshop\event\assessment_evaluated $event): void {
        if (!get_config('block_gamification', 'enable_peerassessment')) return;
        $points = (int)(get_config('block_gamification', 'xp_peerassessment') ?? 20);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_workshop', 'block_gamification'));
    }

    // Glossary entry created.
    public static function glossary_entry_created(\mod_glossary\event\entry_created $event): void {
        if (!get_config('block_gamification', 'enable_glossary')) return;
        $points = (int)(get_config('block_gamification', 'xp_glossary') ?? 10);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_glossary', 'block_gamification'));
    }

    // Database record created.
    public static function data_record_created(\mod_data\event\record_created $event): void {
        if (!get_config('block_gamification', 'enable_database')) return;
        $points = (int)(get_config('block_gamification', 'xp_database') ?? 10);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_database', 'block_gamification'));
    }

    // Wiki page created.
    public static function wiki_page_created(\mod_wiki\event\page_created $event): void {
        if (!get_config('block_gamification', 'enable_wiki')) return;
        $points = (int)(get_config('block_gamification', 'xp_wiki') ?? 15);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_wiki_create', 'block_gamification'));
    }

    // Wiki page updated.
    public static function wiki_page_updated(\mod_wiki\event\page_updated $event): void {
        if (!get_config('block_gamification', 'enable_wikiupdate')) return;
        $points = (int)(get_config('block_gamification', 'xp_wikiupdate') ?? 8);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_wiki_update', 'block_gamification'));
    }

    // Resource viewed.
    public static function resource_viewed(\mod_resource\event\course_module_viewed $event): void {
        if (!get_config('block_gamification', 'enable_resourceview')) return;
        $points = (int)(get_config('block_gamification', 'xp_resourceview') ?? 2);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_resourceview', 'block_gamification'));
    }

    // Feedback submitted.
    public static function feedback_submitted(\mod_feedback\event\response_submitted $event): void {
        if (!get_config('block_gamification', 'enable_feedback')) return;
        $points = (int)(get_config('block_gamification', 'xp_feedback') ?? 12);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_feedback', 'block_gamification'));
    }

    // Choice answered.
    public static function choice_answered(\mod_choice\event\answer_submitted $event): void {
        if (!get_config('block_gamification', 'enable_choice')) return;
        $points = (int)(get_config('block_gamification', 'xp_choice') ?? 8);
        self::award_xp_and_notify($event->userid, $points, get_string('reason_choice', 'block_gamification'));
    }
}
