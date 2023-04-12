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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');
require_once($CFG->libdir . '/questionlib.php');

class check_value extends external_api {
    /**
     * Describes the return value for check_value_test
     *
     * @return external_single_structure
     */
    public static function check_value_test_returns() {
        return new external_single_structure([
            'isvalid' => new external_value(PARAM_BOOL, 'Status when check'),
            'message' => new external_value(PARAM_RAW, 'The error message', VALUE_OPTIONAL)
        ]);
    }

    /**
     * Describes the parameters for check_value_test webservice.
     *
     * @return external_function_parameters
     */
    public static function check_value_test_parameters() {
        return new external_function_parameters([
            'input' => new external_value(PARAM_TEXT, 'The input is'),
        ]);
    }


    public static function check_value_test(string $input): array {
        $params = self::validate_parameters(self::check_value_test_parameters(), [
            'input' => $input,
        ]);
        $errors = self::check_value_from_input($params['input']);
        return ['isvalid' => $errors === '', 'message' => $errors];
    }

    public static function check_value_from_input(string $input): string {
        $errors = '';
        if ($input === 'a') {
            $errors = "Error message 1";
        }
        else if ($input === 'b') {
            $errors = "Error message 2";
        }

        return $errors;
    }
}
