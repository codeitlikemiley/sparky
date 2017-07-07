Vue.component('dashboard', {
    props: ['user', 'projects'],
    data () {
        return {
            campaigns: []
        }
    },

    mounted() {
        //
    },
    computed: {
        projectChunks() {
            return _.chunk(this.projects, 3)
        },
    },

    methods: {
        viewProject(id){
            window.location.assign('dashboard/projects/'+id);
        },
        viewProgress(id, name) {
            this.campaigns = [];
            // load a loader circle
            axios.post('dashboard/projects/' + id + '/progress').then(function (response) {
                this.campaigns = response.data
            }.bind(this))
            // check here if campaign is none then display create a campaign
            this.$modal.show(name);
        },
        show(name) {
            this.$modal.show(name);
        },
        hide(name) {
            this.$modal.hide(name);
        }
    }
});
