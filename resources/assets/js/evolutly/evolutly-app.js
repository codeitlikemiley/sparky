/**
 * Export the root Evolutly application.
 */
module.exports = {
    el: '#evolutly-app',


    /**
     * Initial FrontEnd State
     */

    data: {
        // loaded by default
        user: Evolutly.state.user,
        tenant: Evolutly.state.tenant,
        // loaded depending on route
        projects: (Evolutly.state.projects ? Evolutly.state.projects : []),
        // for review if we will remove this or just use json_encode
        'current_project': (Evolutly.state.currentProject ? Evolutly.state.currentProject : null),
        'project_files': (Evolutly.state.currentProjectFiles ? Evolutly.state.currentProjectFiles : []),
        'project_workers': (Evolutly.state.currentProjectWorkers ? Evolutly.state.currentProjectWorkers : [])
    },

    /**
     * The component has been created by Vue.
     */
    created() {
    },

    /**
     * Prepare the application.
     */
    mounted() {
        this.whenReady();
    },

    methods: {
        whenReady() {
            //
        },
    },
};
