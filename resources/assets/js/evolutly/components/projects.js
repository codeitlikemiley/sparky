

Vue.component('projects', {
    props: ['guard','clients', 'tenant','user', 'project', 'workers', 'campaigns'],
    // extra props we might need to add : files and forms
    data () {
        return {
            projectForm: new EvolutlyForm({ project_name: '', client_id: '' }),
            campaignForm: new EvolutlyForm(Evolutly.forms.campaignForm),
            campaignOrderForm: new EvolutlyForm(Evolutly.forms.campaignOrderForm),
            taskForm: new EvolutlyForm(Evolutly.forms.taskForm),
            formBuilderForm: new EvolutlyForm(Evolutly.forms.formBuilderForm),
            currentCampaignId: null,
            fileForm: new EvolutlyForm(Evolutly.forms.fileForm),
            order_from: '',
            order_to: ''
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
        slug: function(name) {
        var slug = this.sanitizeName(name);
        return slug;
        },
        sanitizeName: function(name) {
        var slug = "";
        // Change to lower case
        var nameLower = name.toString().toLowerCase();
        // Letter "e"
        slug = nameLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
        // Letter "a"
        slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
        // Letter "o"
        slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
        // Letter "u"
        slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
        // Letter "d"
        slug = slug.replace(/đ/gi, 'd');
        // Trim the last whitespace
        slug = slug.replace(/\s*$/g, '');
        // Change whitespace to "-"
        slug = slug.replace(/\s+/g, '-');
        
        return slug;
        },
        campaignChunks(campaigns) {
            return _.chunk(campaigns, 2)
        },
        twoColumn(campaigns){
            return Math.floor(campaigns.length /2)
        },
        whenReady(){
            this.projectForm.project_name = this.project.name
            this.projectForm.client_id = _.find(this.clients, {id: this.project.client_id})
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
                self.$popup({ message: _.first(error.response.data.campaign_name) })
            })
            }else {
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
        editCampaignModal(campaign)
        {
            this.campaignForm.campaign_name = campaign.name
            this.campaignForm.campaign_order = campaign.order
            this.$modal.show(this.slug(campaign.name))
        },
        //works like charm
        updateCampaign(campaign) {
            var self = this
            if (this.guard === 'web') {
                axios.post('/dashboard/campaigns/' + campaign.id + '/edit', self.campaignForm)
                    .then(function (response) {
                        self.$modal.hide(self.slug(campaign.name))
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
        onStart(e){

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

})
