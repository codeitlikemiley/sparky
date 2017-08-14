Vue.component('dashboard', {
    props: ['guard', 'tenant', 'user', 'projects' ,'clientlist'],
    data () {
        return {
            campaigns: [],
            projectForm: new EvolutlyForm(Evolutly.forms.projectForm),
            styling: {
                clearBottom: false,
            },
            clients: []
        }
    },

    mounted() {
        this.clients = this.clientlist
    },
    computed: {
        hasNoProject(){
            if(this.projects.length < 4){
                this.styling.clearBottom = true
            }
        }
    },

    methods: { 
        resetProjectForm(){
            this.projectForm = new EvolutlyForm({client_name: '', client_id: '', newclient: false, user_name: '', user_email: '', user_password: ''})
        },
        projectChunks(projects) {
            return _.chunk(projects, 3)
        },
        campaignProgress(campaign)
        {
            if(campaign.total_points > 0)
            {
                return Math.floor((campaign.done_points / campaign.total_points) * 100);
            }
            return 0;
        },
        createProject()
        {
            var  self = this
            if(self.projectForm.newclient){
                delete self.projectForm.client_id
            }else {
                delete self.projectForm.user_name
                delete self.projectForm.user_email
                delete self.projectForm.user_password
            }
            if(self.guard === 'web')
            {
                let location = '/dashboard/clients/create'
                let url = `${window.location.protocol}//${Evolutly.domain}${location}`
                axios.post(url, self.projectForm)
                .then(function (response) {
                    self.$modal.hide('add-project');
                    self.projects.push(response.data.project)
                    self.clients = response.data.clients
                    self.resetProjectForm()
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                })
                .catch(error => {
                    self.projectForm.errors.set(error.response.data.errors)
                    self.$popup({ message: error.response.data.message })
                })
            }else{
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        deleteProject(index,id) {
            var self = this
            if (self.guard === 'web') {
                axios.post('/dashboard/clients/' + id + '/delete')
                    .then(function (response) {
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        self.projects.splice(index, 1)
                        self.projectForm.client_name = response.data.project
                        self.projectForm.client_name = ''
                    })
                    .catch(error => {
                        self.$popup({ message: _.first(error.response.data.campaign_name) })
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        viewProject(id) {
            let location = '/dashboard/clients/'+id
            if (this.guard === 'employee') {
                location = '/team/dashboard/clients/'+id
            }else if(this.guard === 'client'){
                location = '/client/dashboard/clients/'+id
            }
            let url = `${window.location.protocol}//${Evolutly.domain}${location}`
            console.log(url)
            window.location.href = url
        },
        viewProgress(id,name) {
            let location = '/dashboard/clients/' + id + '/progress'
            if (this.guard === 'employee') {
                location = '/team/dashboard/clients/'+id + '/progress'
            }else if(this.guard === 'client'){
                location = '/client/dashboard/clients/'+id + '/progress'
            }
            let url = `${window.location.protocol}//${Evolutly.domain}${location}`
            this.campaigns = [];
            // load a loader circle
            axios.post(url).then(function (response) {
                this.campaigns = response.data
                this.$modal.show(name);
            }.bind(this))
        },
        show(name) {
            this.$modal.show(name);
        },
        hide(name) {
            this.$modal.hide(name);
        }
    },
});
