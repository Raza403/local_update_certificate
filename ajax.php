<?php
require('../../config.php');
require_login();

$query = optional_param('query', '', PARAM_TEXT);
$userid = optional_param('userid', 0, PARAM_INT);

if ($query) {
    // Handle autocomplete for users
    $users = $DB->get_records_sql('SELECT id, CONCAT(firstname, " ", lastname) AS name 
                                   FROM {user} 
                                   WHERE CONCAT(firstname, " ", lastname) LIKE ? 
                                   AND deleted = 0', ['%' . $query . '%']);

    $suggestions = [];
    foreach ($users as $user) {
        $suggestions[] = ['id' => $user->id, 'name' => $user->name];
    }

    header('Content-Type: application/json');
    echo json_encode(['suggestions' => $suggestions]);
} elseif ($userid) {
    // Handle course retrieval based on user
    $enrolled_courses = enrol_get_users_courses($userid);
    
    $courses = [];
    foreach ($enrolled_courses as $course) {
        $courses[] = ['id' => $course->id, 'fullname' => $course->fullname];
    }

    header('Content-Type: application/json');
    echo json_encode(['courses' => $courses]);
}
