<?php
require_once('../../config.php');
require_once('classes/form/update_form.php');

global $DB, $USER;

$context = context_system::instance();
require_login();
require_capability('moodle/site:config', $context);

$PAGE->set_url(new moodle_url('/local/update_certificate/index.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_update_certificate'));

$mform = new \local_update_certificate\form\update_form();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/'));
} else if ($fromform = $mform->get_data()) {
    // Process the form data
    if (isset($fromform->completiondate) && is_numeric($fromform->completiondate)) {
        $completiondate = intval($fromform->completiondate); // Ensure it's an integer
    } else {
        $completiondate = 0; // Handle unexpected data
    }

    $userid = $fromform->userid;
    $courseid = $fromform->courseid;

    // Check if the record exists
    if ($record = $DB->get_record('course_completions', array('userid' => $userid, 'course' => $courseid))) {
        $record->timecompleted = $completiondate;

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
    $mform->display();
    echo $OUTPUT->footer();
    exit;
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
