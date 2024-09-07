YUI.add('moodle-availability_message-form', function (Y, NAME) {

/**
 * JavaScript for form editing message conditions.
 *
 * @module moodle-availability_message-form
 */
M.availability_message = M.availability_message || {};

/**
 * @class M.availability_message.form
 * @extends M.core_availability.plugin
 */
M.availability_message.form = Y.Object(M.core_availability.plugin);

/**
 * Initialises this plugin.
 *
 * @method initInner
 * @param {Array} cms Array of objects containing cmid => name
 */
M.availability_message.form.initInner = function(e) {
	this.standardFields = e;
};

M.availability_message.form.getNode = function(json) {
    // Create HTML structure.
    var html = '<label><span class="pr-3">'+ M.util.get_string('conditiontitle', 'availability_message') +
            '</span><select class="custom-select" name="message" title="' + M.util.get_string('conditiontitle', 'availability_message') + '">' +
            '<option value="0">' + M.util.get_string('choosedots', 'moodle') + '</option>';

	for (
		var i,
			s = 0;
		s < this.standardFields.length;
		s++
	)
		html += '<option value="' + (i = this.standardFields[s]).field + '">' + i.display + "</option>";
    html += '</select></label>';
    var node = Y.Node.create('<span class="form-inline">' + html + '</span>');

    // Set initial values.
    if (json.message !== undefined &&
            node.one('select[name=message] > option[value=' + json.message + ']')) {
        node.one('select[name=message]').set('value', '' + json.message);
    }


    // Add event handlers (first time only).
    if (!M.availability_message.form.addedEvents) {
        M.availability_message.form.addedEvents = true;
        var root = Y.one('.availability-field');
        root.delegate('change', function() {
            // Whichever dropdown changed, just update the form.
            M.core_availability.form.update();
        }, '.availability_message select');
        
        root.delegate('keyup', function() {
                // The key point is this update call. This call will update
                // the JSON data in the hidden field in the form, so that it
                // includes the new value of the checkbox.
                M.core_availability.form.update();
        }, '.availability_message input');
    }
    

    return node;
};

M.availability_message.form.fillValue = function(value, node) {
    value.message = node.one('select[name=message]').get('value');
};

M.availability_message.form.fillErrors = function(errors, node) {
    var messageid = node.one('select[name=message]').get('value');
    if (messageid === 0) {
        errors.push('availability_message:error_selectfield');
    }
    
};


}, '@VERSION@', {"requires": ["base", "node", "event", "moodle-core_availability-form"]});
