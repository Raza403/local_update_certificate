<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    'local/update_certificate:manage' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'admin' => CAP_ALLOW,
        ),
    ),
);
