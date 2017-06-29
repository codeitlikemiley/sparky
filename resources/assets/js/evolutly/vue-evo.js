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
Vue.mixin(require('mixin'));

/**
 * Define the Vue filters.
 */
// relative path: 
// resources/assets/js/evolutly
require('filters');

/**
 * Load the Evolutly form utilities.
 */
// relative path: 
// resources/assets/js/evolutly
require('forms/evo-form-bootstrap');
