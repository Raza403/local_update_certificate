<?php
require_once('../../config.php');
require_once('classes/form/update_form.php');

global $DB, $USER;

$context = context_system::instance();
require_login();
require_capability('moodle/site:config', $context);

$PAGE->set_url(new moodle_url('/local/update_certificate/index.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('updatecompletiondate', 'local_update_certificate'));

// Load the necessary JS for AJAX and autocomplete
$PAGE->requires->js('/local/update_certificate/js/update_courses.js');
$PAGE->requires->js('/local/update_certificate/js/autocomplete.js'); // JS file for autocomplete

$mform = new \local_update_certificate\form\update_form();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/'));
} else if ($fromform = $mform->get_data()) {
    // Process the form data
    $completiondate = isset($fromform->completiondate) && is_numeric($fromform->completiondate) ? intval($fromform->completiondate) : 0;
    $userid = $fromform->userid;
    $courseid = $fromform->courseid;

    // Update completion date logic (same as before)
    if ($record = $DB->get_record('course_completions', ['userid' => $userid, 'course' => $courseid])) {
        $record->timecompleted = $completiondate;
        $DB->update_record('course_completions', $record);
    }

    // Only update the renew by date if courseid is 2 and renewbydate is provided
    if ($courseid == 2 && isset($fromform->renewbydate)) {
        // Fetch the itemid for "Renew by" date
        $itemid = $DB->get_field('grade_items', 'id', ['courseid' => $courseid, 'idnumber' => '222']);

        if ($itemid) {
            // Fetch timemodified and id for renew by date
            $grade_record = $DB->get_record('grade_grades', ['userid' => $userid, 'itemid' => $itemid]);

            if ($grade_record && is_null($grade_record->timemodified)) {
                $message = get_string('renewactivityerror', 'local_update_certificate');
                $alert_class = 'alert-danger';
            } else if ($grade_record) {
                // Update the timemodified with the renew by date
                $renewbydate = isset($fromform->renewbydate) ? intval($fromform->renewbydate) : 0;
                if ($renewbydate > 0) {
                    $grade_record->timemodified = $renewbydate; // Modify the existing record's timemodified field
                    $DB->update_record('grade_grades', $grade_record);
                }
            }
        }
    }

    // Display the success or error message
    echo $OUTPUT->header();
    echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">';
    echo '<strong>' . $message . '</strong>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';

    // Recreate the form to reset fields
    $mform = new \local_update_certificate\form\update_form();
    $mform->set_data($fromform);
    $mform->display();
    echo $OUTPUT->footer();
    exit;
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('updatecompletiondate', 'local_update_certificate')); // This adds the heading to the page
$mform->display();
echo $OUTPUT->footer();
