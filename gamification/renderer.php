<?php
defined('MOODLE_INTERNAL') || die();

class block_gamification_renderer extends plugin_renderer_base {

    public function user_summary(int $xp, int $rank): string {
        $html  = html_writer::start_div('gamification-user-summary');

        // ⭐ XP
        $html .= html_writer::start_div('summary-item');
        $html .= html_writer::div('⭐', 'summary-icon');
        $html .= html_writer::div(get_string('yourxp', 'block_gamification'), 'summary-label');
        $html .= html_writer::div(number_format($xp), 'summary-value');
        $html .= html_writer::end_div();

        // 🏆 Rank
        $html .= html_writer::start_div('summary-item');
        $html .= html_writer::div('🏆', 'summary-icon');
        $html .= html_writer::div(get_string('yourrank', 'block_gamification'), 'summary-label');
        $html .= html_writer::div(number_format($rank), 'summary-value');
        $html .= html_writer::end_div();

        $html .= html_writer::end_div();
        return $html;
    }

    public function render_leaderboard(array $users, ?int $highlightid = null): string {
        $html = '';

        // Leaderboard scrollable container
        $html .= html_writer::start_div('gamification-container');
        $html .= html_writer::start_tag('table', ['class' => 'generaltable gamification-table']);

        // Header
        $html .= html_writer::start_tag('thead');
        $html .= html_writer::tag('tr',
            html_writer::tag('th', get_string('rank', 'block_gamification')) .
            html_writer::tag('th', get_string('profile', 'block_gamification')) .
            html_writer::tag('th', get_string('user', 'block_gamification')) .
            html_writer::tag('th', get_string('xp', 'block_gamification'))
        );
        $html .= html_writer::end_tag('thead');

        // Sequential rank counter
        $ranknum = 1;

        // Body
        $html .= html_writer::start_tag('tbody');
        foreach ($users as $u) {
            $rowclass = ($highlightid && (int)$highlightid === (int)$u->id) ? 'highlight' : '';

            // Top 3 medals
            if ($ranknum === 1) {
                $rankdisplay = '🥇';
            } else if ($ranknum === 2) {
                $rankdisplay = '🥈';
            } else if ($ranknum === 3) {
                $rankdisplay = '🥉';
            } else {
                $rankdisplay = '<strong>' . $ranknum . '</strong>';
            }

            // Avatar + name split into columns
            $userpic  = $this->output->user_picture($u, ['size' => 40, 'class' => 'avatar']);
            $fullname = fullname($u);

            $html .= html_writer::tag('tr',
                html_writer::tag('td', $rankdisplay, ['class' => 'rank-col']) .
                html_writer::tag('td', $userpic, ['class' => 'profile-col']) .
                html_writer::tag('td', $fullname, ['class' => 'name-col']) .
                html_writer::tag('td', number_format((int)$u->xp), ['class' => 'xp-col']),
                ['class' => $rowclass]
            );

            $ranknum++;
        }
        $html .= html_writer::end_tag('tbody');
        $html .= html_writer::end_tag('table');
        $html .= html_writer::end_div(); 

        return $html;
    }

    public function render_give_xp_form(): string {
        global $PAGE;

        // Only show to teachers/admins with permission.
        if (!has_capability('block/gamification:givexp', $PAGE->context)) {
            return '';
        }

        $url = new \moodle_url('/blocks/gamification/givexp.php');
        $ajaxurl = new \moodle_url('/blocks/gamification/ajax.php');

        $html  = html_writer::start_div('gamification-givexp-form');
        $html .= html_writer::start_tag('form', [
            'method' => 'post',
            'action' => $url,
            'onsubmit' => 'return validateXpForm(this);'
        ]);

        // === Row 1: User search + XP input ===
        $html .= html_writer::start_div('form-row');
        $html .= '<div class="autocomplete-wrapper">';
        $html .= '<input type="text" id="usersearch" placeholder="' .
            get_string('chooseuser', 'block_gamification') .
            '" class="xp-input" autocomplete="off">';
        $html .= '<input type="hidden" name="userid" id="userid">';
        $html .= '</div>';

        $html .= html_writer::empty_tag('input', [
            'type' => 'number',
            'name' => 'points',
            'min' => '1',
            'class' => 'xp-input xp-number',
            'placeholder' => get_string('enterpoints', 'block_gamification') 
        ]);

        $html .= html_writer::end_div();

        // === Row 2: Buttons ===
        $html .= html_writer::start_div('form-row buttons');
        $html .= html_writer::empty_tag('input', [
            'type' => 'submit',
            'name' => 'action',
            'value' => get_string('givexp', 'block_gamification'),
            'class' => 'btn btn-primary'
        ]);
        $html .= html_writer::empty_tag('input', [
            'type' => 'submit',
            'name' => 'action',
            'value' => get_string('takexp', 'block_gamification'),
            'class' => 'btn btn-danger'
        ]);
        $html .= html_writer::end_div();

        $html .= html_writer::end_tag('form');
        $html .= html_writer::end_div();

        // === Export button (separate row) ===
        $exporturl = new \moodle_url('/blocks/gamification/export.php');
        if (has_capability('block/gamification:view', $this->page->context)) {
            $html .= html_writer::div(
                html_writer::link($exporturl, get_string('exportcsv', 'block_gamification'), [
                    'class' => 'btn btn-secondary gamification-export'
                ]),
                'gamification-export-row'
            );
        }

        $val_user_points = get_string('val_user_points', 'block_gamification');
        $val_user = get_string('val_user', 'block_gamification');
        $val_points = get_string('val_points', 'block_gamification');
        $confirm_takexp = get_string('confirmtakexp', 'block_gamification');
        $takexp_label = get_string('takexp', 'block_gamification');

        // JavaScript for AJAX live search + validation
        $html .= "
        <script>
            const searchInput = document.getElementById('usersearch');
            const hiddenId = document.getElementById('userid');
            let suggestionBox;
            let clickedButtonValue = '';

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.gamification-givexp-form input[type=\"submit\"]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        clickedButtonValue = btn.value;
                    });
                });
            });

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                if (suggestionBox) suggestionBox.remove();

                if (query.length < 2) {
                    hiddenId.value = '';
                    return;
                }

                fetch('{$ajaxurl}?term=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(users => {
                        if (users.length === 0) return;

                        suggestionBox = document.createElement('div');
                        suggestionBox.classList.add('autocomplete-suggestions');

                        users.forEach(u => {
                            const item = document.createElement('div');
                            item.textContent = u.name;
                            item.classList.add('autocomplete-item');
                            item.onclick = () => {
                                searchInput.value = u.name;
                                hiddenId.value = u.id;
                                suggestionBox.remove();
                            };
                            suggestionBox.appendChild(item);
                        });

                        searchInput.parentNode.appendChild(suggestionBox);
                    });
            });

            document.addEventListener('click', function(e) {
                if (suggestionBox && !searchInput.contains(e.target) && !suggestionBox.contains(e.target)) {
                    suggestionBox.remove();
                }
            });

            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && suggestionBox) {
                    suggestionBox.remove();
                }
            });

            function validateXpForm(form) {
                const user = form.userid.value;
                const points = form.points.value.trim();
                const errorBoxId = 'gamification-error-box';
                let errorBox = document.getElementById(errorBoxId);

                if (!errorBox) {
                    errorBox = document.createElement('div');
                    errorBox.id = errorBoxId;
                    errorBox.className = 'gamification-error-box';
                    form.prepend(errorBox);
                }

                let errorMessage = '';
                if (!user && !points) {
                    errorMessage = '{$val_user_points}';
                } else if (!user) {
                    errorMessage = '{$val_user}';
                } else if (!points || isNaN(points) || points <= 0) {
                    errorMessage = '{$val_points}';
                }

                if (errorMessage) {
                    errorBox.textContent = errorMessage;
                    errorBox.style.display = 'block';
                    setTimeout(() => { errorBox.style.display = 'none'; }, 3000);
                    return false;
                }

                // Only confirm if user clicked 'Take XP'
                if (clickedButtonValue === '{$takexp_label}') {
                    return confirm('{$confirm_takexp}');
                }

                return true;
            }
        </script>
        ";

        return $html;
    }

    public function render_toast_js(): string {
        return "
        <script>
        function showXpToast(message) {
            let toast = document.createElement('div');
            toast.className = 'gamification-toast';
            toast.innerHTML = message;
            document.body.appendChild(toast);

            setTimeout(() => toast.classList.add('show'), 100);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }
        </script>
        ";
    }
}
