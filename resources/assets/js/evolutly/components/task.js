
Vue.component('task', {
    props: ['guard','workers', 'tenant','user', 'task', 'project', 'client', 'campaign', 'activities'],
    // remove activity logs props
    data () {
        return {
            taskForm: new EvolutlyForm(Evolutly.forms.taskForm),
            subtaskForm: new EvolutlyForm(Evolutly.forms.subtaskForm),
            assignEmployeeForm: new EvolutlyForm(Evolutly.forms.assignEmployeeForm),
            ratingForm: new EvolutlyForm(Evolutly.forms.ratingForm),
            commentForm: new EvolutlyForm(Evolutly.forms.commentForm),
            subtasks: [],
            comments: [],
            progress: '0%',
            total: 0,
            done: 0,
            logs: null,


        }
    },
    mounted() {
        this.whenReady()
    },
    computed: {
        
    },
    methods: {
        whenReady() {
            this.fetchSubtasks()
            this.setInitialTask()
            this.setInitialTaskPoints()
            this.setInitialLogs()
        },
        fetchSubtasks(){
            let location = ''
            let self = this
            if(self.guard === 'employee'){
                location = `/team/dashboard/tasks/${self.task.id}/subtasks`
            }else if(self.guard === 'client') {
                location = `/client/dashboard/tasks/${self.task.id}/subtasks`
            }else{
                location = `/dashboard/tasks/${self.task.id}/subtasks`
            }
            axios.get(location).then((response) => {
                self.subtasks = response.data.subtasks
                
            })
        },
        setInitialTask(){
            this.taskForm.task_name = this.task.name
            this.taskForm.task_link = this.task.link
            this.taskForm.task_description = this.task.description
        },
        setInitialTaskPoints(){
            this.total = this.task.total_points
            this.done = this.task.done_points
        },
        setInitialLogs(){
            this.logs = this.activities
        },
        computeProgress(){
            let self = this
            let total = _.sum(_.map(self.subtasks, 'points'))
            this.total = total ? total : 0
            let done =_.sum(_.map(self.subtasks, (subtask) => {
                if(subtask.done){
                    return subtask.points
                }
            }))
            this.done = done ? done : 0
            let percent = Math.floor((done / total) * 100)
             if(isNaN(percent)){
                self.progress = '0%'
             }else{
                self.progress = `${percent}%`
             }
        },
        editTaskModal(){
            this.show('edit-task-modal')
        },
        updateTask(){
            let location = ''
            let self = this
            if(self.guard === 'web'){
                location = `/dashboard/tasks/${self.task.id}/edit`
                axios.put(location,self.taskForm).then(function (response) { 
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                    self.$modal.hide('edit-task-modal')
                    self.taskForm.resetStatus()
                    self.updateLogs(response.data.log)
                    
                }).catch(error => {
                    self.taskForm.errors.set(error.response.data.errors)
                    self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
                })
            }else{
                self.$popup({ message: 'Oops Cant Do That!' }) 
            }
            
        },
        updateLogs(log){
            this.logs.push(log)
        },

        deleteTaskModal(){
            this.show('delete-task-modal')
            console.log('Delete Task Modal Launched!')
        },
        deleteTask(){
            let self = this
            if(self.guard === 'web'){
                axios.delete(`/dashboard/tasks/${self.task.id}/delete`).then((response) => {
                    window.location.href = `/dashboard/projects/${self.project.id}`
                })
            }else{
                self.$popup({ message: 'Oops Cant Do That!' }) 
            }
            
        },
        addSubtask(){
            let self = this
            axios.post(`dashboard/subtasks/create`,self.subtaskForm).then((response) => {
                self.subtasks.push(response.data)
            })
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
        editSubtask(subtask){
            let self = this
            axios.post(`dashboard/tasks/${self.task.id}/subtasks/${subtask.id}/edit`,self.subtaskForm).then((response) => {
                
            })
        },
        deleteSubtask(subtask){
            var self = this
            if (this.guard === 'web') {
                axios.delete(`/dashboard/tasks/${self.task.id}/subtasks/${subtask.id}/delete`)
                    .then(function (response) {
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        let index = _.findIndex(self.subtasks, { id: subtask.id })
                        self.$delete(self.subtasks, index)
                    })
                    .catch(error => {
                        self.$popup({ message: _.first(error.response.data.message) })
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        toggleDone(subtask){
            let self = this
            let location = ''
            if(self.guard === 'employee'){
                location = `/team/dashboard/tasks/${self.task.id}/subtasks/${subtask.id}/toggle`
                axios.put(location).then((response) => {
                    let index = _.findIndex(self.subtasks, { id: subtask.id }).
                    console.log(index)
                    self.$set(self.subtasks, index, response.data.subtask)
                    console.log(response.data.subtask)
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                })
            }else if(self.guard === 'web'){
                location = `/dashboard/tasks/${self.task.id}/subtasks/${subtask.id}/toggle`
                axios.put(location).then((response) => {
                    let index = _.findIndex(self.subtasks, { id: subtask.id })
                    self.$set(self.subtasks, index, response.data.subtask)
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                })
            }else{
                self.$popup({ message: 'Oops Cant Do That!' })
            }
            
        },
        assignEmployee(){
            let self = this
            let location = `dashboard/tasks/${self.task.id}/subtasks/${subtasks.id}/assignEmployee`

            axios.post(location,self.assignEmployeeForm).then((response) => {

            })
        },
        setRating(){
            let self = this
            let location = `dashboard/tasks/${self.task.id}/subtasks/${subtasks.id}/setRating`

            axios.post(location,self.ratingForm).then((response) => {

            })
        },
        fetchActivityLogs(){
            let self = this
            axios.get(`dashboard/tasks/${self.task.id}/activitylogs`).then((response) => {
                self.activities = response.data
            })
        },
        fetchComments(){
            let self = this
            axios.get(`dashboard/tasks/${self.task.id}/comments`).then((response) => {
                self.comments = response.data
            })
        },
        addComment(){
            let location = ''
            let self = this
            if(self.guard === 'employee'){
                location = `team/dashboard/tasks/${task.id}/addComment`
            }else if(self.guard === 'client') {
                location = `client/dashboard/tasks/${task.id}/addComment`
            }else{
                location = `dashboard/tasks/${tasks.id}/addComment`
            }
            axios.post(location,self.commentForm).then((response) => {

            })
        },
        editComment(){
            let location = ''
            let self = this
            if(self.guard === 'employee'){
                location = `team/dashboard/tasks/${task.id}/editComment`
            }else if(self.guard === 'client') {
                location = `client/dashboard/tasks/${task.id}/editComment`
            }else{
                location = `dashboard/tasks/${tasks.id}/editComment`
            }
            axios.post(location,self.commentForm).then((response) => {

            })
        },
        deleteComment(){
            if(self.guard === 'web'){
                axios.post(`dashboard/tasks/${task.id}/deleteComment`,self.commentForm).then((response) => {
                    
                })
            }else{
                console.log('Unauthorized!')
            }
        },
        viewLink(){
            let self = this
            window.open(self.task.link, '_blank');
        },
        viewVideoLink(subtask){
            window.open(subtask.link, '_blank');
        },
        showAddSubtaskModal(){
            console.log('showing add subtask modal')
        },
        show(name) {
            this.$modal.show(name)
        },
        hide(name) {
            this.$modal.hide(name)
        },
    },
    watch: {
        subtasks(newValue){
            this.computeProgress()
        }
    }


})
