import StarRating from 'vue-star-rating'

Vue.component('task', {
    props: ['guard','employees', 'tenant','user', 'task', 'project', 'client', 'campaign', 'activities'],
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
            endpoints: {
                web: null,
                team: null,
                client: null,
            },
            rating: 1,
            priority: 1,
            currentSubtask: null


        }
    },
    mounted() {
        this.whenReady()
    },
    computed: {
        
    },
    methods: {
        // Overried pass array of valid guard from backend
        // By Default Uses This Array
        // Passed A Callback Function To Execute For Example Api Calls
        guardAllowed(guards = ['web', 'employee', 'client'],callback){
            let self = this
            if(_.includes(guards, self.guard)){
                callback
                self.resetEndpoints()
            }else{
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        resetEndpoints(){
            this.endpoints = {
                web: null,
                team: null,
                client: null,
            }
        },
        guardedLocation({web,team,client} = this.endpoints){
            let self = this
            if(self.guard === 'client'){
                return client
            }else if(self.guard === 'employee'){
                return team
            }else{
                return web
            }
        },
        show(name) {
            this.$modal.show(name)
        },
        hide(name) {
            this.$modal.hide(name)
        },
        whenReady() {
            let self = this
            self.guardAllowed(self.fetchSubtasks())
            self.setInitialTask()
            self.setInitialTaskPoints()
            self.setInitialLogs()
        },
        fetchSubtasks(){
            let self = this
            self.endpoints.web = `/dashboard/tasks/${self.task.id}/subtasks`
            self.endpoints.team = `/team/dashboard/tasks/${self.task.id}/subtasks`
            self.endpoints.client = `/client/dashboard/tasks/${self.task.id}/subtasks`
            axios.get(self.guardedLocation()).then((response) => {
                self.subtasks = response.data.subtasks
            })
        },
        setInitialTask(){
            let self = this
            self.taskForm.task_name = self.task.name
            self.taskForm.task_link = self.task.link
            self.taskForm.task_description = self.task.description
            self.taskForm.task_recurring = self.task.recurring
            self.taskForm.task_interval = self.task.interval
        },
        setInitialTaskPoints(){
            let self = this
            self.total = self.task.total_points
            self.done = self.task.done_points
        },
        setInitialLogs(){
            let self = this
            self.logs = self.activities
        },
        overDueDate(subtask){
            if(subtask.done == false && subtask.due_date > moment(new Date).format('YYYY-MM-DD')){
                return true
            }
        },
        computeProgress(){
            let self = this
            let total = _.sumBy(_.map(self.subtasks, 'points'), (val) => { return parseInt(val) })
            self.total = total ? total : 0
            let done =_.sum(_.map(self.subtasks, (subtask) => {
                if(subtask.done){
                    return parseInt(subtask.points)
                }
            }))
            self.done = done ? done : 0
            let percent = Math.floor((done / total) * 100)
             if(isNaN(percent)){
                self.progress = '0%'
             }else{
                self.progress = `${percent}%`
             }
        },
        editTaskModal(){
            let self = this
            self.guardAllowed(['web'],self.show('edit-task-modal'))
        },
        updateTask(){
            let self = this
            self.guardAllowed(['web'],self.callApiUpdateTask())
        },
        callApiUpdateTask(){
            let self = this
            self.endpoints.web = `/dashboard/tasks/${self.task.id}/edit`
            axios.put(self.guardedLocation(),self.taskForm).then( (response) => { 
                self.taskForm.resetStatus()
                // self.updateLogs(response.data.log)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                self.$modal.hide('edit-task-modal')
                
            }).catch(error => {
                self.taskForm.errors.set(error.response.data.errors)
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        updateLogs(log){
            this.logs.push(log)
        },
        deleteTaskModal(){
            let self = this
            self.guardAllowed(['web'],self.show('delete-task-modal'))
        },
        deleteTask(){
            let self = this
            self.guardAllowed(['web'],self.callApiDeleteTask())
        },
        callApiDeleteTask(){
            let self = this
            self.endpoints.web = `/dashboard/tasks/${self.task.id}/delete`
            axios.delete(self.guardedLocation()).then((response) => {
                window.location.href = `/dashboard/projects/${self.project.id}`
            })
        },
        toggleDone(subtask){
            let self = this
            self.guardAllowed(['web','employee'],self.callApiToggleSubtask(subtask))
        },
        callApiToggleSubtask(subtask){
            let self = this
            self.endpoints.web = `/dashboard/tasks/${self.task.id}/subtasks/${subtask.id}/toggle`
            self.endpoints.team = `/team/dashboard/tasks/${self.task.id}/subtasks/${subtask.id}/toggle`
            axios.put(self.guardedLocation()).then((response) => {
                let index = _.findIndex(self.subtasks, { id: subtask.id })
                self.$set(self.subtasks, index, response.data.subtask)
                // self.updateLogs(response.data.log)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
        },
        deleteSubtask(subtask){
            var self = this
            self.guardAllowed(['web'],self.callApiDeleteSubtask(subtask))
        },
        callApiDeleteSubtask(subtask){
            var self = this
            self.endpoints.web = `/dashboard/tasks/${self.task.id}/subtasks/${subtask.id}/delete`
            axios.delete(self.guardedLocation())
            .then(function (response) {
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                let index = _.findIndex(self.subtasks, { id: subtask.id })
                self.$delete(self.subtasks, index)
            })
            .catch(error => {
                self.$popup({ message: _.first(error.response.data.message) })
            })
        },
        viewLink(){
            window.open(this.task.link, '_blank');
        },
        viewVideoLink(subtask){
            window.open(subtask.link, '_blank');
        },
        setRating(rating){
            let self = this
            self.rating = rating
        },
        setCurrentSubtask(subtask){
            this.currentSubtask = subtask
        },
        updateRating(newValue){
            let self = this
            self.ratingForm.subtask_priority = newValue
            self.subtaskForm.priority = newValue
            self.guardAllowed(['web'],self.callApiSetRatings(self.currentSubtask))
        },
        callApiSetRatings(subtask){
            let self = this
            self.endpoints.web = `/dashboard/ratings/${subtask.id}`
            axios.put(self.guardedLocation(),self.ratingForm)
            .then((response) => {
                self.ratingForm.subtask_priority = 1
                let index = _.findIndex(self.subtasks, { id: subtask.id })
                self.$set(self.subtasks, index, response.data.subtask)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
            .catch(error => {
                self.ratingForm.errors.set(error.response.data.errors)
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        setPriority(rating){
            let self = this
            self.priority = rating
        },
        addSubtaskModal(){
            let self = this
            self.subtaskForm = new EvolutlyForm(Evolutly.forms.subtaskForm)
            self.guardAllowed(['web'],self.show('add-subtask-modal'))
        },
        addSubtask(){
            let self = this
            self.guardAllowed(['web'],self.callApiAddSubTask())
        },
        callApiAddSubTask(){
            let self = this
            self.endpoints.web = `/dashboard/tasks/${self.task.id}/subtasks/add`
            axios.post(self.guardedLocation(), self.subtaskForm)
            .then((response) => {
                self.subtaskForm.resetStatus()
                self.subtaskForm = new EvolutlyForm(Evolutly.forms.subtaskForm)
                self.subtasks.push(response.data.subtask)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                self.hide('add-subtask-modal')
            })
            .catch((error) => {
                self.subtaskForm.errors.set(error.response.data.errors)
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        // not yet done
        editSubtaskModal(subtask){
            let self = this
            self.guardAllowed(['web'],self.show('edit-subtask-modal-'+subtask.id))
            self.guardAllowed(['web'],self.assignSubtaskToForm(subtask))
        },
        assignSubtaskToForm(subtask){
            let self = this
            self.subtaskForm.name = subtask.name
            self.subtaskForm.link = subtask.link
            self.subtaskForm.points = subtask.points 
            self.subtaskForm.priority = subtask.priority
            self.subtaskForm.employees = subtask.employees
            self.subtaskForm.due_date = moment(subtask.due_date).format('YYYY-MM-DD')
            self.subtaskForm.done = subtask.done
        },
        closeEditSubtask(subtask){
            let self = this 
            self.hide(`edit-subtask-modal-${subtask.id}`)
            self.subtaskForm = new EvolutlyForm(Evolutly.forms.subtaskForm)
        },
        editSubtask(subtask){
            let self = this
            self.guardAllowed(['web'],self.callApiEditSubtask(subtask))
            
        },
        callApiEditSubtask(subtask){
            let self = this
            self.endpoints.web = `/dashboard/tasks/${self.task.id}/subtasks/${subtask.id}/edit`
            axios.put(self.guardedLocation(),self.subtaskForm)
            .then((response) => {
                self.subtaskForm.resetStatus()
                let index = _.findIndex(self.subtasks, { id: subtask.id })
                self.$set(self.subtasks, index, response.data.subtask)
                self.hide(`edit-subtask-modal-${subtask.id}`)
                self.subtaskForm = new EvolutlyForm(Evolutly.forms.subtaskForm)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
            .catch(error => {
                if(error.response.data.errors){
                self.subtaskForm.errors.set(error.response.data.errors)
                }
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        assignEmployee(subtask){
            let self = this
            self.guardAllowed(['web'],self.callApiAssignEmployees(subtask))
            
        },
        callApiAssignEmployees(subtask){
            let self = this
            self.endpoints.web = `dashboard/tasks/${self.task.id}/subtasks/${subtasks.id}/assignEmployee`
            axios.post(self.guardedLocation(),self.assignEmployeeForm)
            .then((response) => {

            })
            .catch(error => {
                self.$popup({ message: _.first(error.response.data.message) })
            })
        },  
        fetchComments(){
            let self = this
            self.guardAllowed(self.callApiGetComments)
        },
        callApiGetComments(){
            let self = this
            self.endpoints.web = `dashboard/tasks/${self.task.id}/comments`
            self.endpoints.team = `dashboard/tasks/${self.task.id}/comments`
            self.endpoints.client = `dashboard/tasks/${self.task.id}/comments`

            axios.get(self.guardedLocation())
            .then((response) => {

            })
            .catch(error => {
                self.$popup({ message: _.first(error.response.data.message) })
            })
        },
        addComment(){
            let self = this
            self.guardAllowed(self.callApiAddComment())
        },
        callApiAddComment(){
            let self = this
            self.endpoints.web = `dashboard/tasks/${tasks.id}/addComment`
            self.endpoints.team =`team/dashboard/tasks/${task.id}/addComment`
            self.endpoints.client = `client/dashboard/tasks/${task.id}/addComment`

            axios.post(self.guardedLocation(),self.commentForm)
            .then((response) => {

            })
            .catch(error => {
                self.$popup({ message: _.first(error.response.data.message) })
            })
        },
        editComment(){
            let self = this
            self.guardAllowed(self.callApiEditComment())
        },
        callApiEditComment(){
            let self = this
            self.endpoints.web = `dashboard/tasks/${tasks.id}/editComment`
            self.endpoints.team =`team/dashboard/tasks/${task.id}/editComment`
            self.endpoints.client = `client/dashboard/tasks/${task.id}/editComment`

            axios.post(self.guardedLocation(),self.commentForm)
            .then((response) => {

            })
            .catch(error => {
                self.$popup({ message: _.first(error.response.data.message) })
            })
        },
        deleteComment(){
            let self = this
            self.guardAllowed(self.callApiDeleteComment())
        },
        callApiDeleteComment(){
            let self = this
            self.endpoints.web = `dashboard/tasks/${task.id}/deleteComment`

            axios.delete(self.guardedLocation())
            .then((response) => {

            })
            .catch(error => {
                self.$popup({ message: _.first(error.response.data.message) })
            })
        }
    },
    watch: {
        subtasks(newValue){
            this.computeProgress()
        },
        rating(newValue){
            this.updateRating(newValue)
            
        },
        priority(newValue){
            this.setPriority(newValue)
            this.subtaskForm.priority = newValue
        }
    },
    components: {
        StarRating
    }

})
