<?php
namespace block_gamification;


defined('MOODLE_INTERNAL') || die();

/**
* Data access layer for gamification leaderboard.
*
* @package block_gamification
*/
class leaderboard_manager {
    /**
    * Get a user's XP (0 if none).
    */
    public function get_user_xp(int $userid): int {
        global $DB;
        $record = $DB->get_record('block_gamification', ['userid' => $userid]);
        return $record ? (int) $record->xp : 0;
    }


    /**
    * Add (or subtract) XP.
    */
    public function add_xp(int $userid, int $points): void {
        global $DB;

        if ($points === 0) {
            return;
        }

        $record = $DB->get_record('block_gamification', ['userid' => $userid]);
        if ($record) {
            $record->xp = max(0, (int) $record->xp + $points);
            $DB->update_record('block_gamification', $record);
        } else {
            $DB->insert_record('block_gamification', (object) [
                'userid' => $userid,
                'xp' => max(0, $points),
            ]);
        }
    }
    /**
    * Return top N users with XP for the leaderboard (includes users with 0 XP for stable ranking).
    * Ordered by xp desc, lastname, firstname, id.
    *
    * @param int $limit
    * @return array of user records with ->id, ->firstname, ->lastname, ->xp
    */
    public function get_leaderboard(int $limit = 50): array {
        global $DB;

        $sql = "
            SELECT u.id, u.firstname, u.lastname, COALESCE(x.xp, 0) AS xp
            FROM {user} u
        LEFT JOIN {block_gamification} x ON x.userid = u.id
            WHERE u.deleted = 0 AND u.suspended = 0
        ORDER BY x.xp DESC, u.lastname ASC, u.firstname ASC, u.id ASC
        ";

        return $DB->get_records_sql($sql, [], 0, $limit);
    }



        /** Get a user's rank against the global leaderboard ordering. */
    public function get_user_rank(int $userid): int {
        global $DB;
        $sql = "
            SELECT u.id, COALESCE(x.xp, 0) AS xp
            FROM {user} u
        LEFT JOIN {block_gamification} x ON u.id = x.userid
            WHERE u.deleted = 0 AND u.suspended = 0
        ORDER BY x.xp DESC, u.lastname ASC, u.firstname ASC, u.id ASC
        ";
        $records = $DB->get_records_sql($sql);
        $rank = 1;
        foreach ($records as $u) {
            if ((int)$u->id === (int)$userid) {
                return $rank;
            }
            $rank++;
        }
        return 0;
    }
}