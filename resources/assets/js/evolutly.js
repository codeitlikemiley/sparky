// Interceptors , Depedencies ,
// Same Level file
require('./evolutly-bootstrap');

// All Our Global Components
// Located at resources/assets/js/evolutly
require('components/evo-components');

var evo = new Vue({
    // mixins are all module.exports
    mixins: [require('evolutly-app')]
});
