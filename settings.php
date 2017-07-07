<?php

defined('MOODLE_INTERNAL') || die;

if($hassiteconfig && isset($ADMIN)){

    $taindex = new admin_externalpage('addCategoryQuestions', "Import Json", "$CFG->wwwroot/local/importjson/index.php", 'moodle/site:config');
    $ADMIN->add('localplugins', $taindex);

}