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
        deleteTemplate(id){
            // Only the Project Creator Can Delete the template
            // guard (employee,projectable_type and id)
            // web ,tenant_id and auth user id
            let self = this
            let index = _.findIndex(self.templates, { id: id })
            self.$delete(self.templates, index)
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
