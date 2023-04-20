<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * The main mod_plugintest configuration form.
 *
 * @package     mod_plugintest
 * @copyright   2023 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form.
 *
 * @package     mod_plugintest
 * @copyright   2023 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_plugintest_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        // Adding the "general" fieldset, where all the common settings are shown.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('plugintestname', 'mod_plugintest'), array('size' => '64'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'plugintestname', 'mod_plugintest');

        // Adding the standard "intro" and "introformat" fields.
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements();
        } else {
            $this->add_intro_editor();
        }

        // Adding the rest of mod_plugintest settings, spreading all them into this fieldset
        // ... or adding more fieldsets ('header' elements) if needed for better logic.
        $mform->addElement('static', 'label1', 'plugintestsettings', get_string('plugintestsettings', 'mod_plugintest'));
        $mform->addElement('header', 'plugintestfieldset', get_string('plugintestfieldset', 'mod_plugintest'));


        $repeatarray = array();
        $repeatarray[] = $mform->createElement('textarea', 'option', get_string('optionno', 'choice'));
        $repeatarray[] = $mform->createElement('textarea', 'limit', get_string('limitno', 'choice'));
        $repeatarray[] = $mform->createElement('hidden', 'optionid', 0);

        if ($this->_instance){
            $repeatno = $DB->count_records('choice_options', array('choiceid'=>$this->_instance));
            $repeatno += 2;
        } else {
            $repeatno = 5;
        }

        $repeateloptions = array();
        $repeateloptions['limit']['default'] = 0;
        $repeateloptions['limit']['disabledif'] = array('limitanswers', 'eq', 0);
        $repeateloptions['limit']['type'] = PARAM_INT;

        $repeateloptions['option']['helpbutton'] = array('choiceoptions', 'choice');
        $mform->setType('option', PARAM_CLEANHTML);

        $mform->setType('optionid', PARAM_INT);


        $options = ['maxlength' => 100, 'cols' => 30, 'rows' => 5];
        $mform->addElement('textarea', 'foo', 'ISSUE MDL-76003', $options);
        $mform->setType('foo', PARAM_TEXT);
        $mform->addRule('foo', 'maxlength >4', 'maxlength', 4, 'client');

        $options = ['maxlength' => 100, 'cols' => 30, 'rows' => 5];
        $mform->addElement('text', 'feee', 'ISSUE MDL-76003');
        $mform->setType('feee', PARAM_TEXT);
        $mform->addRule('feee', 'maxlength >4', 'maxlength', 4, 'client');

        //$mform->addElement('duration', 'timelimit', 'duration');
        //$mform->addRule('timelimit', 'maxlength >4', 'maxlength', 4, 'client');


        $mform->addElement('text', 'fieldtext', 'forum');
        $mform->setType('fieldtext', PARAM_TEXT);
        $mform->addRule('fieldtext', 'maxlength >4', 'maxlength', 4, 'client');

        // add editor.
        $mform->addElement('editor', 'fieldname', 'editor');
        $mform->setType('fieldname', PARAM_RAW);
        $mform->addRule('fieldname', 'This element is required', 'numeric', null, 'client');



        $options = array(
            'a' => 'a',
            'b' => 'b',
        );
        $mform->addElement('select', 'multi-select', "multi-select", $options);
        // Add date selector.
        $mform->addElement('date_selector', 'datepicker', get_string('to'));

        // Add date-time selector.
        $mform->addElement('date_time_selector', 'date-time-selector', 'date time selector');

        // Add select yes no.
        $mform->addElement('selectyesno', 'selectyesno', 'selectyesno');

        $this->repeat_elements($repeatarray, $repeatno,
                $repeateloptions, 'option_repeats', 'option_add_fields', 3, null, true);
        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();

        //$this->js_call();
    }

    public function js_call() {
        global $PAGE;
        $PAGE->requires->js_call_amd('mod_plugintest/check_value', 'init');
    }
}
