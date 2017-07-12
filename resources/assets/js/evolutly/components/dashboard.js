import Multiselect from 'vue-multiselect'
Vue.component('dashboard', {
    props: ['guard', 'tenant', 'user', 'projects' ,'clients'],
    data () {
        return {
            campaigns: [],
            projectForm: new EvolutlyForm({project_name: '', client_id: ''}),
        }
    },

    mounted() {
    },
    computed: {
        projectChunks() {
            return _.chunk(this.projects, 3)
        },
        
    },

    methods: { 
        campaignProgress(campaign)
        {
            return Math.floor((campaign.done / campaign.total) * 100);
        },
        createProject()
        {
            if(this.guard === 'web')
            {
                axios.post('dashboard/projects/create', this.projectForm)
                .then(function (response) {
                    this.$modal.hide('add-project');
                    this.projects.push(response.data.project)
                    this.projectForm.project_name = ''
                    this.projectForm.client_id = ''
                    this.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                }.bind(this))
                .catch(error => {
                    this.$popup({ message: 'Name is required' })
                })
            }else{
                this.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        viewProject(id) {
            let location = '/dashboard/projects/'+id
            if (this.guard === 'employee') {
                location = '/employee/dashboard/projects/'+id
            }
            let url = `${window.location.protocol}//${this.tenant.username}.${Evolutly.domain}${location}`

            window.location.href = url
        },
        viewProgress(id,name) {
            this.campaigns = [];
            // load a loader circle
            axios.post('dashboard/projects/' + id + '/progress').then(function (response) {
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
    components: { Multiselect },
});
