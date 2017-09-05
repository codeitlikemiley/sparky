import guards from './../../mixins/guard'

Vue.component('employee-management', {
    mixins: [guards],
    props:['user','teams','clients'],
    data () {
        return {
            employees: [],
            registerForm: new EvolutlyForm(Evolutly.forms.registerForm),
            projects: [],
            current_employee: null,
            current_index: null,
            current_project: null,
            current_project_index: null,
            current_subtask: null,
            current_subtask_index: null,
            membertasks:[]
        }
    },
    mounted() {
        this.employees = this.teams
        this.projects = this.clients
    },
    methods:{
        show(name) {
             this.$modal.show(name)
        },
        hide(name) {
             this.$modal.hide(name)
        },
        showAddEmployeeModal(){
            let self = this 
            self.resetRegisterForm()
            self.show('add-employee-modal')
        },
        addEmployee(){
            let self = this
            self.guardAllowed(['web'],self.callAddEmployeeApi())
        },
        closeAddEmployeeModal(){
            let self = this
            self.resetRegisterForm()
            self.hide('add-employee-modal')
        
        },
        resetCurrentEmployee(){
            let self = this
            self.current_employee = null
            self.current_index = null
            self.current_project = null
            self.current_project_index = null
            self.current_subtask = null
            self.current_subtask_index = null
        },
        resetRegisterForm(){
            let self = this
            self.registerForm = new EvolutlyForm(Evolutly.forms.registerForm)
        },
        fillRegisterForm(employee){
            let self = this
            self.registerForm.name = employee.name
            self.registerForm.email = employee.email
            self.registerForm.password = employee.password
        },
        callAddEmployeeApi(){
            let self = this
            self.endpoints.web = '/users/teammates'
            axios.post(self.guardedLocation(), self.registerForm)
             .then((response) => {
                 self.registerForm.resetStatus()
                 self.resetRegisterForm()
                 self.employees.push(response.data.employee)
                 self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                 self.hide('add-employee-modal')
             })
             .catch((error) => {
                 self.registerForm.errors.set(error.response.data.errors)
                 self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
             })
            
        },
        showEditModal(employee,employeeKey){
            let self = this
            self.guardAllowed(['web'],self.fillRegisterForm(employee))
            self.guardAllowed(['web'],self.show('edit-employee-modal'))
            self.current_index = employeeKey
            self.current_employee = employee
        },
        closeEditModal(){
            let self = this
            self.guardAllowed(self.resetRegisterForm())
            self.guardAllowed(['web'],self.hide('edit-employee-modal'))
            self.resetCurrentEmployee()
        },
        editEmployee(){
            let self = this
            if(!self.registerForm.password){
                delete self.registerForm.password
                delete self.registerForm.password_confirmation
            }
            self.endpoints.web = `/users/teammates/${self.current_employee.id}/edit`
             axios.put(self.guardedLocation(), self.registerForm)
             .then((response) => {
                self.registerForm.resetStatus()
                 self.$set(self.employees, self.current_index, response.data.employee)
                 self.closeEditModal()
                 self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
             })
             .catch((error) => {
                if(!self.registerForm.password){
                    self.registerForm.password = ''
                }
                if(!self.registerForm.password_confirmation){
                    self.registerForm.password_confirmation = ''
                }
                 self.registerForm.errors.set(error.response.data.errors)
                 self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
             })
        },
        showDeleteModal(employee,employeeKey){
            let self = this
            self.current_employee = employee
            self.current_index = employeeKey
            self.guardAllowed(['web'],self.show('delete-employee-modal'))
            
        },
        closeDeleteModal(){
            let self = this
            self.resetCurrentEmployee()
            self.guardAllowed(['web'],self.hide('delete-employee-modal'))
            
        },
        deleteEmployee(){
            let self = this
            self.endpoints.web = `/users/teammates/${self.current_employee.id}/delete`
            axios.delete(self.guardedLocation())
            .then(function (response) {
                self.employees.splice(self.current_index,1)
                self.resetCurrentEmployee()
                self.$popup({ message: `Teammate Has Been Deleted.`, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                self.hide('delete-employee-modal')
            })
            .catch(error => {
                if(error.response.data.message){
                    self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Failed To Update Data in the Server', backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }
            })
        },
        
        overDueDate(subtask){
            if(subtask.done == false && subtask.due_date < moment(new Date).format('YYYY-MM-DD')){
                return true
            }
        },
        removeSubtask(){
            let self = this
            self.employees[self.current_index].assignedprojects[self.current_project_index].subtasks.splice(self.current_subtask_index,1)
        },
        removeEmployeeProjectAssignment(){
            let self = this
            if(self.employees[self.current_index].assignedprojects[self.current_project_index].subtasks.length == 0){
                self.deleteAllProjects()
                self.guardAllowed(['web'],self.hide(`project-subtasks-modal-${self.current_project.id}`))
            }
        },
        deleteAllProjects(){
            let self = this
            self.employees[self.current_index].assignedprojects.splice(self.current_project_index,1)
        },
        unassigneSubtask(employee,employeeKey,project,projectKey,subtask,subtaskKey){
            let self = this
            self.endpoints.web = `/users/teammates/${employee.id}/clients/${project.id}/subtasks/${subtask.id}/detach`
            self.current_employee = employee
            self.current_index = employeeKey
            self.current_project = project
            self.current_project_index = projectKey
            self.current_subtask = subtask
            self.current_subtask_index = subtaskKey
            
            axios.delete(self.guardedLocation())
            .then( (response) => {
                self.resetEndpoints()
                self.removeSubtask()
                self.removeEmployeeProjectAssignment()
                self.resetCurrentEmployee()
                self.$popup({ message: `Task Has Been Unassigned`, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
            })
            .catch(error => {
                if(error.response.data.message){
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Failed To Update Data in the Server', backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }
            })
            
        },
        deleteAllTasks(employee,employeeKey,project,projectKey){
            let self = this
            self.current_employee = employee
            self.current_index = employeeKey
            self.current_project = project
            self.current_project_index = projectKey
            self.endpoints.web = `/users/teammates/${employee.id}/clients/${project.id}/detach`

            axios.delete(self.guardedLocation())
            .then( (response) => {
                self.resetEndpoints()
                self.deleteAllProjects()
                self.resetCurrentEmployee()
                self.$popup({ message: `All Tasks Related To This Client Deleted`, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
            })
            .catch(error => {
                if(error.response.data.message){
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Failed To Update Data in the Server', backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }
            })
        },
        viewJob(id) {
            window.open(`/dashboard/jobs/${id}`)
        },
        viewAssignedSubtask(employee,task){
            let self = this
            self.guardAllowed(['web'],self.fillWorkerTasks(employee,task))
        },
        closeAssignedSubtaskModal(task){
            let self = this
            self.guardAllowed(['web'],self.hide(`task-subtasks-modal-${task.id}`))
            self.membertasks = []
        },
        fillWorkerTasks(employee,task){
            let self = this
            self.endpoints.web = `/jobs/${task.id}/employee/${employee.id}/subtasks`
            axios.get(self.guardedLocation()).then((response) => {
                self.membertasks = response.data.subtasks
                self.show(`task-subtasks-modal-${task.id}`)
            })
        },
        removeSubtask(task,employee,subtask){
            let self = this 
            self.endpoints.web = `/jobs/${task.id}/employee/${employee.id}/unassignsubtask/${subtask.id}`
            axios.get(self.guardedLocation()).then((response) => {
                let memberIndex = _.findIndex(self.membertasks, { id: subtask.id })
                self.$delete(self.membertasks, memberIndex)
                if(self.membertasks.length < 1){
                    self.closeAssignedSubtaskModal(task)
                }
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
        },
     }
});
