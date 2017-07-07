<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from a Moodle page.
}

require_once($CFG->libdir.'/formslib.php');

class importjson_form extends moodleform {

    public function definition() {

        global $DB;

        // Max size file
        $maxbytes = 256;

        $mform = &$this->_form;

		$mform->addElement('filepicker', 'userfile', get_string('file'), null, array('maxbytes' => $maxbytes, 'accepted_types' => '*'));
        $this->add_action_buttons(false, 'Importar');

    }

}