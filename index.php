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
    $renewbydate = isset($fromform->renewbydate) && is_numeric($fromform->renewbydate) ? intval($fromform->renewbydate) : 0; // New field

    $userid = $fromform->userid;
    $courseid = $fromform->courseid;

    // Check if the record exists
    if ($record = $DB->get_record('course_completions', array('userid' => $userid, 'course' => $courseid))) {
        $record->timecompleted = $completiondate;
        $record->renewby = $renewbydate; // Assuming you add this field in the database later

        if ($DB->update_record('course_completions', $record)) {
            $message = get_string('completiondateset', 'local_update_certificate');
            $alert_class = 'alert-success';
        } else {
            $message = get_string('error', 'local_update_certificate');
            $alert_class = 'alert-danger';
        }
    } else {
        $message = get_string('error', 'local_update_certificate'); // Record not found
        $alert_class = 'alert-danger';
    }

    echo $OUTPUT->header();
    echo '<div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">';
    echo '<strong>' . $message . '</strong>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';

    // Display the form again with reset fields
    $mform = new \local_update_certificate\form\update_form(); // Recreate the form to reset fields
    $mform->set_data($fromform); // Set the form data to retain the selected values
    $mform->display();
    echo $OUTPUT->footer();
    exit;
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('updatecompletiondate', 'local_update_certificate')); // This adds the heading to the page
$mform->display();
echo $OUTPUT->footer();
