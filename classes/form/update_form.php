<?php
namespace local_update_certificate\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

use moodleform;

class update_form extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        // Get list of students
        global $DB;
        $students = $DB->get_records_menu('user', null, 'lastname ASC', 'id, CONCAT(firstname, " ", lastname)');
        $mform->addElement('select', 'userid', get_string('selectstudent', 'local_update_certificate'), $students);
        
        // Get list of courses (initially populated)
        $courses = $DB->get_records_menu('course', null, 'fullname ASC', 'id, fullname');
        $mform->addElement('select', 'courseid', get_string('selectcourse', 'local_update_certificate'), $courses);

        // Date selection
        $mform->addElement('date_selector', 'completiondate', get_string('selectdate', 'local_update_certificate'), array('default' => time()));
        
        // Add submit and cancel buttons
        $this->add_action_buttons(true, get_string('setcompletiondate', 'local_update_certificate'));
    }
}
