/**
 * Initialize the Evolutly form extension points.
 */
Evolutly.forms = {
    register: {},
    updateContactInformation: {},
    updateTeamMember: {}
};

/**
 * Load the Evolutly form helper class.
 */
require('./form');

/**
 * Define the Evolutly form Error collection class.
 */
require('./errors');

/**
 * Add additional HTTP / form helpers to the Evolutly object.
 */
$.extend(Evolutly, require('./http'));
