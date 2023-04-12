// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * This is plugin test.
 *
 * @module    mod_plugintest
 * @class     check_value
 * @copyright 2023 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {call as fetchMany} from 'core/ajax';
import * as FormEvents from 'core_form/events';

/**
 * Validation for expression.
 */
const check_value = () => {
    const inputs = document.querySelectorAll('textarea[name*="limit"]');
    inputs.forEach(input => {
        input.addEventListener('blur', function(e) {
            const promises = fetchMany([{
                methodname: 'webservice_call_test',
                args: {
                    input: e.target.value,
                }
            }]);
            promises[0].then(function(data) {
                FormEvents.notifyFieldValidationFailure(e.target, data.message);
            }).fail(function(err) {
                window.console.error('Log request failed ' + err.message);
            });
        });
    });
};

export const init = () => {
    check_value();
};