<?php
require('../../config.php');
require_login();

$userid = required_param('userid', PARAM_INT);

// Fetch enrolled courses for the selected user
$enrolled_courses = enrol_get_users_courses($userid);

$courses = [];
foreach ($enrolled_courses as $course) {
    $courses[] = ['id' => $course->id, 'fullname' => $course->fullname];
}

// Return the list of courses as JSON
header('Content-Type: application/json');
echo json_encode(['courses' => $courses]);
