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
 * User message field condition.
 *
 * @package availability_message
 * @copyright 2024 Lmskaran.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_message;

defined('MOODLE_INTERNAL') || die();

/**
 * User message field condition.
 *
 * @package availability_message
 * @copyright 2024 Lmskaran.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition extends \core_availability\condition {


    /** @var array|null Array of custom message fields (static cache within request) */
    protected static $custommessagefields = null;

    /** @var string Field name (for standard fields) or '' if custom field */
    protected $standardfield = '';

    /** @var int Field name (for custom fields) or '' if standard field */
    protected $customfield = '';


    /**
     * Constructor.
     *
     * @param \stdClass $structure Data structure from JSON decode
     * @throws \coding_exception If invalid data structure.
     */
    public function __construct($structure) {
		$this->message = $structure->message;
    }

    public function save() {
        $result = (object)array('type' => 'message');
		

        return $result;
    }

    /**
     * Returns a JSON object which corresponds to a condition of this type.
     *
     * Intended for unit testing, as normally the JSON values are constructed
     * by JavaScript code.
     *
     * @param bool $customfield True if this is a custom field
     * @param string $fieldname Field name
     * @param string $operator Operator name (OP_xx constant)
     * @param string|null $value Value (not required for some operator types)
     * @return stdClass Object representing condition
     */
    public static function get_json($customfield, $fieldname) {
        $result = (object)array('type' => 'message');

        return $result;
    }

    public function is_available($not, \core_availability\info $info, $grabthelot, $userid) {
		global $DB;
        $allow = false;
		$table = 'user_preferences';
		$row = get_user_preferences('message_provider_moodle_instantmessage_enabled', '', $userid);
		if($row)
		{
			$value = $row->value;
			$values = explode(',', $value);
			if(in_array($this->message, $values))
			{
				$allow = true;
			}
		}
		
        if ($not) {
            $allow = !$allow;
        }
        return $allow;
    }

    public function get_description($full, $not, \core_availability\info $info) {
        $course = $info->get_course();
		global $USER, $CFG;
        // Display the fieldname into current lang.
        $a = new \stdClass();
        // Not safe to call format_string here; use the special function to call it later.
        
        if ($not) {
            // When doing NOT strings, we replace the operator with its inverse.
            // Some of them don't have inverses, so for those we use a new
            // identifier which is only used for this lang string.
            
        }
        return get_string('requires_message', 'availability_message', array('wwwroot' => $CFG->wwwroot, 'message' => $this->message, 'userid' => $USER->id));
    }


    /**
     * Return list of standard user message fields used by the condition
     *
     * @return string[]
     */
    public static function get_standard_message_fields(): array {
		$pluginmanager = \core_plugin_manager::instance();
        $enabled = $pluginmanager->get_enabled_plugins('message');

		$result = array();
		
		foreach ($enabled as $plugin => $info)
		{
			$result[$plugin] = get_string('pluginname', "message_$plugin");
		}
		return $result;
    }

    /**
     * Wipes the static cache (for use in unit tests).
     */
    public static function wipe_static_cache() {
        self::$custommessagefields = null;
    }

    /**
     * Return the value for a user's message field
     *
     * @param int $userid User ID
     * @return string|bool Value, or false if user does not have a value for this field
     */
    

	protected function get_debug_string(): string {
        return '';
    }

}
