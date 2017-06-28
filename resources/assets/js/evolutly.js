// Interceptors , Depedencies ,
require('./evolutly-bootstrap');

// All Our Global Components
require('bootstrap-components');

var evo = new Vue({
    // mixins are all module.exports
    mixins: [require('./evolutly/evolutly')]
});
