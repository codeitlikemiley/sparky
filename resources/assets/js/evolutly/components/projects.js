import FileUpload from 'vue-upload-component'

Vue.component('projects', {
    props: ['guard','clients', 'tenant','user', 'project', 'workers', 'campaigns'],
    // extra props we might need to add : files and forms
    data () {
        return {
            projectForm: new EvolutlyForm(Evolutly.forms.projectForm),
            campaignForm: new EvolutlyForm(Evolutly.forms.campaignForm),
            campaignOrderForm: new EvolutlyForm(Evolutly.forms.campaignOrderForm),
            taskForm: new EvolutlyForm(Evolutly.forms.taskForm),
            formBuilderForm: new EvolutlyForm(Evolutly.forms.formBuilderForm),
            currentCampaignId: null,
            fileForm: new EvolutlyForm(Evolutly.forms.fileForm),
            files: []
        }
    },
    mounted() {
        this.whenReady()
    },
    computed: {
        
        employeeChunks() {
            return _.chunk(this.workers, 4)
        },
    },
    methods: {
        whenReady() {
            this.projectForm.project_name = this.project.name
            this.projectForm.client_id = _.find(this.clients, { id: this.project.client_id })
        },
        campaignChunks(campaigns) {
            return _.chunk(campaigns, 2)
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
            this.$popup({ message: 'Viewing Task', backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            window.location.href = url
        },
        isTaskDone(task){
            return task.done == 1;
        },
        createTask() {
            var self = this

            let location = `/dashboard/campaigns/${self.currentCampaignId}/tasks/create`
            let url = `${window.location.protocol}//${self.tenant.username}.${Evolutly.domain}${location}`

            if (this.guard === 'web') {

                axios.post(url, self.taskForm).then(function (response) {
                    let index = _.findIndex(self.campaigns, { id: self.currentCampaignId })
                    self.campaigns[index].tasks.push(response.data.task)
                    self.taskForm.resetStatus()
                    self.taskForm = new EvolutlyForm(Evolutly.forms.taskForm)

                    self.$popup({ message: response.data.message })
                })
                    .catch(error => {
                        self.taskForm.errors.set(error.response.data.errors)
                        self.$popup({ message: error.response.data.message })
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }

        },
        updateProject(id) {
            var self = this
            if (this.guard === 'web') {
            axios.post('/dashboard/projects/' + id + '/edit', self.projectForm)
            .then(function (response) {
                self.$modal.hide('edit-project');
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
            .catch(error => {
                self.$popup({ message: _.first(error.response.data.project_name) })
            })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        deleteProject() {
            var self = this
            if (this.guard === 'web') {
                axios.post('/dashboard/projects/' + self.project.id + '/delete')
                    .then(function (response) {
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        let location = '/dashboard'
                        let url = `${window.location.protocol}//${self.tenant.username}.${Evolutly.domain}${location}`
                        window.location.replace(url)
                    })
                    .catch(error => {
                        self.$popup({ message: _.first(error.response.data.campaign_name) })
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        createCampaign() {
            var self = this
            if (this.guard === 'web') {
            
            axios.post('/dashboard/projects/' + self.project.id + '/campaigns/create', self.campaignForm)
            .then(function (response) {
                self.$modal.hide('add-campaign');
                self.campaigns.push(response.data.campaign)
                self.campaignForm.campaign_name = ''
                self.campaignForm.campaign_order = 0
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
            .catch(error => {
                self.$popup({ message: _.first(error.response.data.message) })
            })
            }else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
            
        },
        
        editCampaignModal(campaign)
        {
            this.campaignForm.campaign_name = campaign.name
            this.campaignForm.campaign_order = campaign.order
            this.$modal.show('campaign-'+campaign.id)
        },
        //works like charm
        updateCampaign(campaign) {
            var self = this
            if (this.guard === 'web') {
                axios.post('/dashboard/campaigns/' + campaign.id + '/edit', self.campaignForm)
                    .then(function (response) {
                        self.$modal.hide('campaign-'+ campaign.id)
                        let index = _.findIndex(self.campaigns, { id: campaign.id })
                        console.log(index)
                        self.$set(self.campaigns, index, response.data.campaign)
                        // hack to rerender the dom
                        self.campaignForm.campaign_name = ''
                        self.campaignForm.campaign_order = ''
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                    })
                    .catch(error => {
                        self.$popup({ message: _.first(error.response.data.message) })
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        onEnd(e){
            var self = this
            // if 0 then we are going right
            // if 1 then we are going left
            let left = 0
            let right = 1
            let leftOrRight = parseInt(e.target.getAttribute('leftOrRight'))
            let max = parseInt(e.target.getAttribute('max'))
            let id = e.target.getAttribute('data-id')
            let order = ((max + 1) * 2)
            let position = null
            
            if(leftOrRight === left)
            {
                position = order - 1
                
            }else{
                position = order
            }
            console.log(position)
            self.switchCampaign(position,id)
            
        },
        switchCampaign(position,id) {
            var self = this
            self.campaignOrderForm.campaign_order = parseInt(position)
            if (this.guard === 'web') {
                axios.post('/dashboard/campaigns/' + id + '/reorder', self.campaignOrderForm)
                    .then(function (response) {
                        
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        return true;
                    })
                    .catch(error => {
                        self.$popup({ message: error.response.data.message })
                        return false;
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
                return false;
            }
        },
        // works like charm
        deleteCampaign(campaign) {
            var self = this
            if (this.guard === 'web') {
                axios.post('/dashboard/campaigns/' + campaign.id + '/delete')
                    .then(function (response) {
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        let index = _.findIndex(self.campaigns, { id: campaign.id })
                        console.log(index)
                        self.$delete(self.campaigns, index)
                        // hack to rerender the dom
                        self.campaignForm.campaign_name = response.data.campaign.name
                        self.campaignForm.campaign_name = ''
                        self.campaignForm.campaign_order = 0
                        
                    })
                    .catch(error => {
                        self.$popup({ message: _.first(error.response.data.message) })
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
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
    },
    components: {
        FileUpload
    }

})
