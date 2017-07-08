Vue.component('projects', {
    props: ['guard','tenant','user', 'project', 'workers', 'campaigns'],
    // extra props we might need to add : files and forms
    data () {
        return {
            projectForm: new EvolutlyForm(Evolutly.forms.projectForm),
            campaignForm: new EvolutlyForm(Evolutly.forms.campaignForm),
            taskForm: new EvolutlyForm(Evolutly.forms.taskForm),
            formBuilderForm: new EvolutlyForm(Evolutly.forms.formBuilderForm),
            currentCampaignId: null,
            fileForm: new EvolutlyForm(Evolutly.forms.fileForm)
        }
    },
    mounted() {
        this.whenReady()
    },
    computed: {
        campaignChunks() {
            return _.chunk(this.campaigns, 2)
        },
        employeeChunks() {
            return _.chunk(this.workers, 4)
        },
    },
    methods: {
        whenReady(){
            this.projectForm.name = this.project.name
        },
        showTask(id) {
            this.currentCampaignId = id
            this.$modal.show('add-task')
        },
        hideTask() {
            this.currentCampaignId = null
            this.$modal.hide('add-task')
        },
        viewTask(id) {
            let location = '/dashboard/tasks/'
            if(this.guard==='employee')
            {
                location = '/employee/dashboard/tasks/'
            }
            url = `${window.location.protocol}//${this.tenant.username}.${Evolutly.domain}${location}${id}`

            window.location.href = url
        },
        updateProject(id) {
            var self = this
            axios.post('/dashboard/projects/' + id + '/edit', self.projectForm)
            .then(function (response) {
                self.project.name = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        createTask() {
            var self = this
            axios.post('/dashboard/campaigns/' + self.currentCampaignId + '/create', self.taskForm).then(function (response) {
                let index = _.findIndex(self.campaigns, { id: self.currentCampaignId })
                self.campaigns[index].tasks.push(response.data)
            })
            this.$modal.hide('add-task')
        },
        createCampaign() {
            var self = this
            axios.post('/dashboard/projects/' + self.project.id + '/campaigns/create', self.campaignForm)
            .then(function (response) {
                self.campaigns.push(response.data)
            })
            .catch(error => {
                console.log(error)
            })
        },
        // Soon To Be Added
        createForm(id) {
            axios.post('dashboard/projects/'+id+'/forms/create', this.formBuilderForm)
            .then(function (response) {
                // we need to pass in the data
                // We need to add forms as props
                console.log('push this to forms array')
            }.bind(this))
            .catch(error => {
                console.log(error)
            })
        },
        uploadFile(project) {

            this.fileForm = document.getElementById('file').files[0]
            axios.post('dashboard/projects/' + project.id + '/files/upload', this.fileForm)
            .then(function (response) {
                console.log('push this to files array')
            })
            .catch(error => {
                console.log(error)
            })
        },
        show(name) {
            this.$modal.show(name)
        },
        hide(name) {
            this.$modal.hide(name)
        }
    }
})
