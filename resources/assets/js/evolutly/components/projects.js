Vue.component('projects', {
    props: ['tenant','user', 'project', 'workers', 'campaigns'],

    mounted() {
        console.log('Projects Loaded...')
    },
    computed: {
        campaignChunks() {
            // v-for
            return _.chunk(this.campaigns, 2)
        },
        employeeChunks() {
            // v-for
            return _.chunk(this.workers, 4)
        },
    },

    methods: {
        viewTask(id) {
            window.location.assign('dashboard/tasks/' + id);
        },
        uploadFile() {
            axios.post('dashboard/projects/' + id + '/files/upload').then(function (response) {
                // this will add task to specific campaign
                this.project.files.push(response.data)
            }.bind(this))
        },
        createTask(index,id){
            // id  = campaign id 
            // index = campaign index
            axios.post('dashboard/tasks/' + id + '/create').then(function (response) {
                // this will add task to specific campaign
                this.project.campaigns[index].push(response.data)
            }.bind(this))
        },
        addTask(name) {
            this.$modal.show(name)
            // show add task component modal
        },
        addCampaign(name){
            this.$modal.show(name)
            // show add campaign component modal
        },
        importCampaign(name) {
            this.$modal.show(name)
            // show import campaign component modal
        },
        editProject(name){
            this.$modal.show(name)
        },
        // we will remove all method to get modal
        // this is enough
        show(name) {
            this.$modal.show(name);
        },
        hide(name) {
            this.$modal.hide(name);
        }
    }
});
