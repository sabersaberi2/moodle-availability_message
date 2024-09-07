Availability restriction by Message preferences setting in user profile
========================

Moodle availability plugin which lets users restrict resources, activities and sections based on enrolment methods


Requirements
------------

This plugin requires Moodle 3.11+

Installation
------------

Install the plugin like any other plugin to folder
/availability/condition/message

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage
----------------

After installing the plugin, it is ready to use without the need for any configuration.

Teachers (and other users with editing rights) can add the "User userpreferences" availability condition to activities / resources / sections in their courses and set somthing such as Jabber / Mobile / Web / Telegram or any other messaging system in core of moodle or 3rd party.

If you want to learn more about using availability plugins in Moodle, please see https://docs.moodle.org/404/en/availability_message

How this plugin works
--------------------------------

The availability plugin checks if the user has the correct massage preferences setting and, if set that messaging seystem, grants access to the restricted activity.

However, there is the capability moodle/course:viewhiddenactivities (see https://docs.moodle.org/en/Capabilities/moodle/course:viewhiddenactivities) which is contained in the manager, teacher and non-editing teacher roles by default. If a user has a role which contains moodle/course:viewhiddenactivities, he is able to use an activity / resource / section even if the teacher has restricted it.

