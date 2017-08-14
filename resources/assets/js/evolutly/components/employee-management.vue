<template>
  <div class="tabcontrol2 page-tab" data-role="tabcontrol">
    <ul class="tabs">
        <li>
            <a href="#employee_list" data-url="/employees/edit/">employee List</a>
        </li>
    </ul>
    <div class="frames bg-white">
        <div class="padding10"></div>
        <div id="employee_list">
            <div class="section-wrapper animated fadeInRightBig">
                <div class="panel widget-box">
                    <div class="heading">
                        <div class="title">Manage Employee</div>
                    </div>
                    <div class="content">
                        <div class="text">
                                <button @click="add" class="button small-button primary create-item">Add Employee</button>
                                <div class="table-responsive ">
                                    <table class="table border bordered striped ">
                                        <thead class="">
                                            <tr>
                                                <th class="name-wrap">Name</th>
                                                <th class="align-left">Email</th>
                                                <th>Designations</th>
                                                <th class="option-wrap">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(employee,employeeKey,employeeIndex) in employees" :key="employeeKey" :index="employeeIndex">
                                                <td>{{ employee.name }}</td>
                                                <td class="align-left">{{ employee.email }}</td>
                                                <td class="align-left">
                                                    <span class="tag info" v-for="(project,projectKey,projectIndex) in employee.projects" :key="projectKey" :index="employeeIndex">
                                                        <span class="icon mif-tag"></span>
                                                        {{ project.name }}
                                                    </span>
                                                </td>

                                                <td class="align-left">
                                                    <span class="tag success" @click="show('add-employee-modal')">
                                                        <span class="icon mif-eye">
                                                           
                                                        </span>
                                                    </span>
                                                    <span class="tag info" @click="show('edit-employee-modal')">
                                                        <span class="icon mif-pencil">
                                                            
                                                        </span>
                                                    </span>
                                                    <span class="tag alert" @click="show('delete-employee-modal')"> 
                                                        <span class="icon fa fa-trash">
                                                            
                                                        </span>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import guard from './../../mixins/guard'
export default guard.extend({
    props:['guard','user'],
    data(){
        return {
            employees: {},
            registerForm: new EvolutlyForm(Evolutly.forms.registerForm),
            projects: []
        }
    },
    mounted(){
        this.employees = this.user.employees
        this.fetchProjects()
        
    },
    methods:{
       show(name) {
            this.$modal.show(name)
       },
       hide(name) {
            this.$modal.hide(name)
       },
       add(){
           console.log('add employee')
           let self = this
           self.guardAllowed(['web'],self.callAddEmployeeApi())
       },
       fetchProjects(){
           self.endpoint.web = '/clients'
           this.projects = axios.get(self.guardedLocation())
       },
       callAddEmployeeApi(){
           self.endpoint.web = '/user/employees'
           axios.post(self.guardedLocation(), self.employeeForm)
            .then((response) => {
                self.employeeForm.resetStatus()
                self.employeeForm = new EvolutlyForm(Evolutly.forms.employeeForm)
                self.employeeForm.push(response.data.employee)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                self.hide('add-employee-modal')
            })
            .catch((error) => {
                self.subtaskForm.errors.set(error.response.data.errors)
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
           
       },
      
       edit(index){
            console.log('edit employee')
            self.endpoint.web = '/user/employees'
            axios.post(self.guardedLocation(), self.employeeForm)
            .then((response) => {
                self.employeeForm.resetStatus()
                // get index
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                self.hide('add-employee-modal')
            })
            .catch((error) => {
                self.subtaskForm.errors.set(error.response.data.errors)
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
       },
       destroy(index){
           console.log('delete employee')
       },
       show(employee){
           console.log('show employee')
       }
    }
})
</script>

<style>
  
</style>
