Vue.component('dashboard', {
    props: ['user', 'projects'],

    mounted() {
        //
    },
    computed: {
        projectChunks() {
            return _.chunk(this.projects, 3)
        },
    },
    methods: {
        
    }
});
