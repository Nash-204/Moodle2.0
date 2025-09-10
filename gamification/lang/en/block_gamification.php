<?php
// Language strings for block_gamification.

$string['pluginname'] = 'Gamification';
$string['leaderboard'] = 'Leaderboard';
$string['yourxp'] = 'Your XP';
$string['yourrank'] = 'Your rank';
$string['rank'] = 'Rank';
$string['user'] = 'User';
$string['profile'] = '';
$string['xp'] = 'XP';
$string['exportcsv'] = 'Export CSV';
$string['givexp'] = 'Give XP';
$string['takexp'] = 'Take XP';
$string['chooseuser'] = 'Choose a user...';

// Validation messages.
$string['val_user_points'] = 'Please select a user and enter XP.';
$string['val_user'] = 'Please select a user.';
$string['val_points'] = 'Please enter a valid XP amount.';

// Notifications.
$string['xpgiven'] = 'Successfully given {$a} XP.';
$string['xptaken'] = 'Successfully taken {$a} XP';
$string['xpearnedtoast'] = '🎉 You earned {$a->points} XP for {$a->reason}!';
$string['confirmtakexp'] = 'Are you sure you want to take XP from this user?';

// Reasons (observer messages).
$string['reason_quiz'] = 'submitting a quiz';
$string['reason_course'] = 'completing a course';
$string['reason_daily'] = 'your daily login';
$string['reason_forum_discussion'] = 'starting a forum discussion';
$string['reason_forum_post'] = 'posting in a forum';
$string['reason_assignment'] = 'submitting an assignment';
$string['reason_profilepic'] = 'updating your profile picture';
$string['reason_lesson'] = 'completing a lesson';
$string['reason_workshop'] = 'peer assessment in a workshop';
$string['reason_glossary'] = 'adding a glossary entry';
$string['reason_database'] = 'adding a database record';
$string['reason_wiki_create'] = 'creating a wiki page';
$string['reason_wiki_update'] = 'updating a wiki page';

// Settings labels/descriptions.
$string['xp_coursecompleted'] = 'Course completed';
$string['xp_coursecompleted_desc'] = 'XP awarded when a user completes a course.';

$string['xp_dailylogin'] = 'Daily login';
$string['xp_dailylogin_desc'] = 'XP awarded on first login per day.';

$string['xp_quizpass'] = 'Quiz attempt submitted';
$string['xp_quizpass_desc'] = 'XP for submitting a quiz attempt.';

$string['xp_forumdiscussion'] = 'Forum discussion created';
$string['xp_forumdiscussion_desc'] = 'XP for creating a discussion.';

$string['xp_forumpost'] = 'Forum post created';
$string['xp_forumpost_desc'] = 'XP for creating a post.';

$string['xp_assignment'] = 'Assignment submitted';
$string['xp_assignment_desc'] = 'XP for submitting an assignment.';

$string['xp_profilepic'] = 'Profile picture updated';
$string['xp_profilepic_desc'] = 'XP for updating profile picture.';

$string['xp_lesson'] = 'Lesson completed';
$string['xp_lesson_desc'] = 'XP for completing a lesson.';

$string['xp_peerassessment'] = 'Workshop assessment';
$string['xp_peerassessment_desc'] = 'XP for workshop peer assessment.';

$string['xp_glossary'] = 'Glossary entry created';
$string['xp_glossary_desc'] = 'XP for creating a glossary entry.';

$string['xp_database'] = 'Database record created';
$string['xp_database_desc'] = 'XP for creating a database record.';

$string['xp_wiki'] = 'Wiki page created';
$string['xp_wiki_desc'] = 'XP for creating a wiki page.';

$string['xp_wikiupdate'] = 'Wiki page updated';
$string['xp_wikiupdate_desc'] = 'XP for updating a wiki page.';

// Messaging provider strings.
$string['messageprovider:xpnotification'] = 'Gamification XP earned notifications';
$string['xpearnedsubject'] = 'XP Earned!';
$string['xpearnedfull'] = '🎉 You earned {$a->points} XP for {$a->reason}. Keep it up!';
$string['xpearnedsmall'] = 'Earned {$a->points} XP for {$a->reason}';


