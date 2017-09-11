<template>
  <div>
    <trumbowyg v-model="content"></trumbowyg>
  </div>
</template>

<script>  
import trumbowyg from 'vue-trumbowyg'
import guards from './../../mixins/guard'

export default {   
mixins: [guards],
props:['description'],
data () {
    return {
    content: '',
    editForm: new EvolutlyForm(Evolutly.forms.editForm)
    }
},
mounted () {
    let self = this
    self.content = self.description
    Bus.$on('editDescription', (id) => {
        self.callApiUpdateTask(id)
    })
},
methods: {
    callApiUpdateTask(id){
            let self = this
            self.editForm.task_description = self.content
            self.editForm.busy = true
            self.endpoints.web = `/dashboard/jobs/${id}/edit/description`
            axios.put(self.guardedLocation(),self.editForm).then( (response) => { 
                Bus.$emit('updateDescription', self.content)
                Bus.$emit('closeEditor')
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            }).catch(error => {
                self.editForm.busy = false
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
},
components: {
    trumbowyg
},
watch: {
    content: function(newVal, oldVal) {
    	console.log('value changed from ' + oldVal + ' to ' + newVal);
    }
}
}
</script>
