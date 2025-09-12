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
$string['enterpoints'] = 'Enter XP';

// Validation messages.
$string['val_user_points'] = 'Please select a user and enter XP.';
$string['val_user'] = 'Please select a user.';
$string['val_points'] = 'Please enter a valid XP amount.';
$string['cannotremovexp'] = 'User selected already has 0 XP, nothing to remove.';
$string['cannotassignguest'] = 'Guest users cannot receive XP.';

// Notifications.
$string['xpgiven'] = 'Successfully given {$a} XP.';
$string['xptaken'] = 'Successfully taken {$a} XP';
$string['confirmtakexp'] = 'Are you sure you want to take XP from this user?';
$string['messageprovider:xpnotification'] = 'Gamification XP earned notifications';
$string['xpearnedsubject'] = 'XP Earned!';
$string['xpearnedfull'] = '🎉 You earned {$a->points} XP for {$a->reason}. Keep it up!';
$string['xpearnedsmall'] = '🎉 You Earned {$a->points} XP for {$a->reason}';

// Reasons (observer messages).
$string['reason_quiz'] = 'submitting a quiz';
$string['reason_course'] = 'completing a course';
$string['reason_daily'] = 'your daily login';
$string['reason_courseview'] = 'viewing a course';
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
$string['reason_resourceview'] = 'viewing a resource';
$string['reason_feedback'] = 'submitting feedback';
$string['reason_choice'] = 'answering a choice activity';

// Settings labels/descriptions.
$string['xp_coursecompleted'] = 'Course completed';
$string['xp_coursecompleted_desc'] = 'XP awarded when a user completes a course.';
$string['enable_coursecompleted'] = 'Enable course completion XP';
$string['enable_coursecompleted_desc'] = 'If enabled, users earn XP for completing a course.';

$string['xp_dailylogin'] = 'Daily login';
$string['xp_dailylogin_desc'] = 'XP awarded on first login per day.';
$string['enable_dailylogin'] = 'Enable daily login XP';
$string['enable_dailylogin_desc'] = 'If enabled, users earn XP for their first login each day.';

$string['xp_quizpass'] = 'Quiz attempt submitted';
$string['xp_quizpass_desc'] = 'XP for submitting a quiz attempt.';
$string['enable_quizpass'] = 'Enable quiz submission XP';
$string['enable_quizpass_desc'] = 'If enabled, users earn XP when submitting a quiz attempt.';

$string['xp_forumdiscussion'] = 'Forum discussion created';
$string['xp_forumdiscussion_desc'] = 'XP for creating a discussion.';
$string['enable_forumdiscussion'] = 'Enable forum discussion XP';
$string['enable_forumdiscussion_desc'] = 'If enabled, users earn XP when they start a forum discussion.';

$string['xp_forumpost'] = 'Forum post created';
$string['xp_forumpost_desc'] = 'XP for creating a post.';
$string['enable_forumpost'] = 'Enable forum post XP';
$string['enable_forumpost_desc'] = 'If enabled, users earn XP when posting in a forum.';

$string['xp_assignment'] = 'Assignment submitted';
$string['xp_assignment_desc'] = 'XP for submitting an assignment.';
$string['enable_assignment'] = 'Enable assignment submission XP';
$string['enable_assignment_desc'] = 'If enabled, users earn XP when they submit an assignment.';

$string['xp_profilepic'] = 'Profile picture updated';
$string['xp_profilepic_desc'] = 'XP for updating profile picture.';
$string['enable_profilepic'] = 'Enable profile picture XP';
$string['enable_profilepic_desc'] = 'If enabled, users earn XP when updating their profile picture.';

$string['xp_lesson'] = 'Lesson completed';
$string['xp_lesson_desc'] = 'XP for completing a lesson.';
$string['enable_lesson'] = 'Enable lesson completion XP';
$string['enable_lesson_desc'] = 'If enabled, users earn XP for completing a lesson.';

$string['xp_peerassessment'] = 'Workshop assessment';
$string['xp_peerassessment_desc'] = 'XP for workshop peer assessment.';
$string['enable_peerassessment'] = 'Enable workshop assessment XP';
$string['enable_peerassessment_desc'] = 'If enabled, users earn XP for peer assessment in workshops.';

$string['xp_glossary'] = 'Glossary entry created';
$string['xp_glossary_desc'] = 'XP for creating a glossary entry.';
$string['enable_glossary'] = 'Enable glossary entry XP';
$string['enable_glossary_desc'] = 'If enabled, users earn XP when they add a glossary entry.';

$string['xp_database'] = 'Database record created';
$string['xp_database_desc'] = 'XP for creating a database record.';
$string['enable_database'] = 'Enable database record XP';
$string['enable_database_desc'] = 'If enabled, users earn XP when they add a database record.';

$string['xp_wiki'] = 'Wiki page created';
$string['xp_wiki_desc'] = 'XP for creating a wiki page.';
$string['enable_wiki'] = 'Enable wiki page creation XP';
$string['enable_wiki_desc'] = 'If enabled, users earn XP when creating a wiki page.';

$string['xp_wikiupdate'] = 'Wiki page updated';
$string['xp_wikiupdate_desc'] = 'XP for updating a wiki page.';
$string['enable_wikiupdate'] = 'Enable wiki page update XP';
$string['enable_wikiupdate_desc'] = 'If enabled, users earn XP when updating a wiki page.';

$string['xp_courseview'] = 'Course viewed';
$string['xp_courseview_desc'] = 'XP for viewing a course.';
$string['enable_courseview'] = 'Enable course view XP';
$string['enable_courseview_desc'] = 'Allow users to earn XP for viewing courses (once per day per course)';
$string['reason_courseview'] = 'Viewed a course';

$string['xp_resourceview'] = 'Resource viewed';
$string['xp_resourceview_desc'] = 'XP for viewing a resource.';
$string['enable_resourceview'] = 'Enable resource view XP';
$string['enable_resourceview_desc'] = 'If enabled, users earn XP when viewing a resource.';

$string['xp_feedback'] = 'Feedback submitted';
$string['xp_feedback_desc'] = 'XP for submitting feedback.';
$string['enable_feedback'] = 'Enable feedback submission XP';
$string['enable_feedback_desc'] = 'If enabled, users earn XP when submitting feedback.';

$string['xp_choice'] = 'Choice answered';
$string['xp_choice_desc'] = 'XP for answering a choice activity.';
$string['enable_choice'] = 'Enable choice activity XP';
$string['enable_choice_desc'] = 'If enabled, users earn XP when answering a choice activity.';
