/*
 * Load Vue & Vue-Resource.
 *
 * Vue is the JavaScript framework used by Evolutly.
 */
if (window.Vue === undefined) {
    window.Vue = require('vue');

    window.Bus = new Vue();
}

/**
 * Load Vue Global Mixin.
 */
// relative path: 
// resources/assets/js/evolutly

// This is  a Computed Properties For Evolutly Object
Vue.mixin(require('initial_state'));

/**
 * Define the Vue filters.
 */
// relative path: 
// resources/assets/js/evolutly
require('vue_evo_filters');

/**
 * Load the Evolutly form utilities.
 */
// relative path: 
// resources/assets/js/evolutly
require('forms/evo-form-bootstrap');