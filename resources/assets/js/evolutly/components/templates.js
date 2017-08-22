import guards from './../../mixins/guard'
import campaignlist from './campaignlist.vue'

Vue.component('templates', {
    mixins: [guards],
    props: ['guard','templatelist', 'tenant','user'],
    data () {
        return {
            templates: [],
            current_index: null,
            current_template: null,
            current_campaign: null,
        }
    },
    mounted() {
        let self = this
        self.whenReady()
        Bus.$on('show-jobs-modal', (campaign) => {
            self.showJobs(campaign)
        })
    },
    computed: {
        //
    },
    components: {
        campaignlist
    },
    methods: {
        show(name) {
            this.$modal.show(name);
        },
        hide(name) {
            this.$modal.hide(name);
        },
        templateChunks(templates) {
            return _.chunk(templates, 2)
        },
        showJobs(campaign){
            let self = this
            self.current_campaign = campaign
            self.show('show-jobs-modal')
        },
        closeJobsModal(){
            let self = this
            self.hide('show-jobs-modal')
            self.current_campaign = null
        },
        whenReady() {
        this.templates = this.templatelist
        
        },
        cloneTemplate(id){
            let self = this
            Bus.$emit('clone-template',id)
        },
        deleteTemplate(index,template){
            // Only the Project Creator Can Delete the template
            // guard (employee,projectable_type and id)
            // web ,tenant_id and auth user id
            let self = this
            self.toggleClonable(index,template)
            
        },
        toggleClonable(index,template){
            let self = this
            self.guardAllowed(['web'],self.callToggleCloneApi(index,template))
        },
        callToggleCloneApi(index,template)
        {
            let self = this
            self.current_index = index
            self.endpoints.web = `/projects/${template.id}/toggleClonable`
            axios.post(self.guardedLocation())
            .then((response) => {
                let index = _.findIndex(self.templates, { id: template.id })
                self.$delete(self.templates, index)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                self.current_index = null
            })
            .catch((error) => {
                if(response.data.message){
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Server Failed To Serve the Request.', backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', }) 
                }
            })
        },
        
    },
    watch: {
        templates: {
            handler(newValue){
            },
            deep: true
          }
    },

})
