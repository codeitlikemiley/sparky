// Interceptors , Depedencies ,
require('./evolutly-bootstrap');

// All Our Global Components
require('./evolutly/components');

var evo = new Vue({
    // mixins are all module.exports
    mixins: [require('./evolutly/module')]
});
