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
        }
    },
    mounted() {
        this.whenReady()
    },
    computed: {
        //
    },
    components: {
        campaignlist
    },
    methods: {
        templateChunks(templates) {
            return _.chunk(templates, 2)
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
