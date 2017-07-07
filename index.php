<?php

// To use database
require_once(dirname(__FILE__).'/../../config.php');
// To use forms
require_once('forms.php');

// variable to use database
global $DB;

// Neccessary to define the URL
$course = optional_param('course', 0, PARAM_INT);
$type = optional_param('type', 0, PARAM_INT);
$values = array('course'=>$course, 'type'=>$type);
$url = new moodle_url('/local/importjson/index.php', $values);
$PAGE->set_url($url);

// We need to define the context
$context = context_system::instance();
require_login();
$PAGE->set_context($context);

// Main page title
$title = get_string('pluginname', 'local_importjson');
$PAGE->set_title($title);
$PAGE->set_heading($title);

// Instance class form 
$mform = new importjson_form();

//Form processing
if ($mform->get_data()) {

    $content = $mform->get_file_content('userfile');
    $object_message = json_decode($content);

    foreach ($object_message->persona as $key_field => $data_persona) {
        $obj_persona = new stdClass();
        foreach ($data_persona as $key_field => $value) {
            // Discriminate fields that not is necessary decode
            $field_no_decrypt = ($key_field == 'cantidad') || ($key_field == 'desde') || ($key_field == 'empleado') || ($key_field == 'fechaingreso') || ($key_field == 'hasta');

            if (!$field_no_decrypt) {
                // decode only with base64
                $data_decrypted = base64_decode($value);
                $data_decrypted = iconv('iso-8859-1', 'UTF-8', $data_decrypted);
                $obj_persona->$key_field = $data_decrypted;
            } else {
                $obj_persona->$key_field = $value;
            }
        }
        $DB->insert_record('banco_comercio', $obj_persona);
    }
}

// WE DRAW ALL WEB PAGE - configurations are in the beginning
print $OUTPUT->header();

// Display form
$mform->display();

print $OUTPUT->footer();


