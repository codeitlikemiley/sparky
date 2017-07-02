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
        viewProject(id){
            window.location.replace('dashboard/projects/'+id);
        },
        viewProgress(id){
            window.location.replace('dashboard/projects/'+id+'/progress');
        }
    }
});
