<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Pattern-match question type web service declarations.
 *
 * @package   qtype_pmatch
 * @copyright 2018 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'webservice_call_test' => [
        'classname' => 'check_value',
        'classpath' => 'mod/plugintest/classes/external/check_value.php',
        'methodname' => 'check_value_test',
        'description' => 'Check expression valid or invalid',
        'type' => 'read',
        'capabilities' => 'moodle/question:editall',
        'ajax' => true
    ]
];
