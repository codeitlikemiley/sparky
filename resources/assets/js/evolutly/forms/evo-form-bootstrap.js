/**
 * Initialize the Evolutly form extension points.
 */
Evolutly.forms = {
    updateProfile: {},
    updateProjects: {},
    updateCampaigns: {},
    updateTasks: {},
    updateSubtasks: {},
};

/**
 * Load the Evolutly form helper class.
 */
// relative path: 
// resources/assets/js/evolutly
require('forms/evo-form');

/**
 * Define the Evolutly form Error collection class.
 */
// relative path: 
// resources/assets/js/evolutly
require('forms/evo-errors');

/**
 * Add additional HTTP / form helpers to the Evolutly object.
 */
// relative path: 
// resources/assets/js/evolutly
$.extend(Evolutly, require('forms/evo-http'));
