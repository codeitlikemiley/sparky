<template>
<div class="cell">
<div class="panel widget-box success" data-role="panel">
    <div class="heading align-center">
        <div class="title">Discussion</div>
    </div>
    <div class="content">
        <div  v-if="comments.length > 0">
            <!-- No Parent Id -->
            <ul class="chat-list" v-for="(comment,commentKey,commentIndex) in comments" :key="commentKey" :index="commentIndex">
                <!-- has Parent ID -->
                <li>
                    <a class="place-left">
                        <div class="icon small">
                            <img :src="comment.creator.photo_url" class="circle fit-width">
                        </div>
                    </a>
                    <div>
                        <h5>{{ comment.title }}</h5>
                        <div>{{ comment.body }}</div>
                    </div>
                    <span @click="deleteComment(comment,commentKey)" class="icon mif-minus fg-red" style="position:relative;top:-85px;right:-550px;"></span>
                </li>
                <ul style="list-style-type: none;">
                    <li v-for="(child ,childKey, childIndex) in comment.children" :key="childKey" :index="childIndex">
                        <a href="#" class="place-left">
                        <div class="icon small">
                            <img :src="child.creator.photo_url" class="circle fit-width">
                        </div>
                    </a>
                    <div>
                        <h5>{{ child.title }}</h5>
                        <div>{{ child.body }}</div>
                    </div>
                    <span @click="deleteComment(child,commentKey,childKey)" class="icon mif-minus fg-red" style="position:relative;top:-75px;right:-500px;"></span>
                    </li>
                </ul>
                <form v-on:submit.prevent="addComment(comment.id)">
                <div class="input-control text full-size" data-role="input">
                    <input type="text" class="bg-grayLighter" :placeholder="`Reply To ${comment.creator.name}'s' Thread`" v-model="commentForm.body">
                <button class="button info"><span class="icon mif-bubbles"></span></button>
                </div>
                </form>
            </ul>
        </div>
        <div class="padding10">
        <form v-on:submit.prevent="addComment()">
            <div class="input-control text full-size" data-role="input" style="padding-bottom:100px;">
            <input v-model="commentForm.body" class="bg-grayLighter" placeholder="Create A New Thread"></textarea>
            <button class="button info"><span class="icon mif-bubble"></span></button>
            </div>
        </form>
    </div>
    </div>
    
    
</div>
</div>
</template>

<script>
export default {
    props: ['guard','employees', 'tenant','user', 'task', 'client'],
    data () {
        return {
            commentForm: new EvolutlyForm(Evolutly.forms.commentForm),
            comments: [],
            endpoints: {
                web: null,
                team: null,
                client: null,
            },
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
        resetCommentForm(){
            let self = this
            self.commentForm = new EvolutlyForm(Evolutly.forms.commentForm)
        },
        show(name) {
            this.$modal.show(name)
        },
        hide(name) {
            this.$modal.hide(name)
        },
        whenReady() {
            let self = this
            self.fetchComments()
        },
        showDropDown(comment){
            console.log(comment)
        },
        fetchComments(){
            let self = this
            self.guardAllowed(self.callApiGetComments())
        },
        callApiGetComments(){
            let self = this
            self.endpoints.web = `/dashboard/jobs/${self.task.id}/comments`
            self.endpoints.team = `/dashboard/jobs/${self.task.id}/comments`
            self.endpoints.client = `/dashboard/jobs/${self.task.id}/comments`

            axios.get(self.guardedLocation())
            .then((response) => {
                self.comments = response.data.comments
            })
            .catch(error => {
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        addComment(commentID = null){
            let self = this
            self.guardAllowed(self.callApiAddComment(commentID))
        },
        callApiAddComment(commentID = null){
            let self = this

            self.endpoints.web = `/dashboard/jobs/${self.task.id}/comments/add/${commentID ? commentID : ''}`
            self.endpoints.team =`/team/dashboard/jobs/${self.task.id}/comments/add/${commentID ? commentID : ''}`
            self.endpoints.client = `/client/dashboard/jobs/${self.task.id}/comments/add/${commentID ? commentID : ''}`

            axios.post(self.guardedLocation(),self.commentForm)
            .then((response) => {
                self.commentForm.resetStatus()
                self.resetCommentForm()
                if(response.data.comment.parent_id == null) {
                    self.comments.push(response.data.comment)
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                }
                else{
                   let index = _.findIndex(self.comments, { id: commentID })
                    self.comments[index].children.push(response.data.comment)
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                }
                
            })
            .catch(error => {
                self.commentForm.errors.set(error.response.data.errors)
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        assignCommentToForm(comment){
            let self = this
            self.commentForm.title = comment.title
            self.commentForm.body = comment.body
        },
        editCommentModal(comment){
            let self = this
            self.guardAllowed(self.show(`edit-comment-modal-${comment.id}`))
            self.guardAllowed(self.assignCommentToForm(comment))
        },
        editComment(comment){
            let self = this
            self.guardAllowed(self.callApiEditComment(comment))
        },
        callApiEditComment(comment){
            let self = this
            self.endpoints.web = `/dashboard/jobs/${self.task.id}/comments/edit/${comment.id}`
            self.endpoints.team =`/team/dashboard/jobs/${self.task.id}/comments/edit/${comment.id}`
            self.endpoints.client = `/client/dashboard/jobs/${self.task.id}/comments/edit/${comment.id}`

            axios.post(self.guardedLocation(),self.commentForm)
            .then((response) => {
                self.commentForm.resetStatus()
                self.resetCommentForm()
                let index = _.findIndex(self.comments, { id: comment.id })
                self.$set(self.comments, index, response.data.comment)
            })
            .catch(error => {
                self.commentForm.errors.set(error.response.data.errors)
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        deleteComment(comment,commentIndex=null,childIndex=null){
            let self = this
            self.guardAllowed(self.callApiDeleteComment(comment,commentIndex,childIndex))
        },
        callApiDeleteComment(comment,commentIndex=null,childIndex=null){
            let self = this
            self.endpoints.web = `/dashboard/jobs/${self.task.id}/comments/delete/${comment.id}`
            self.endpoints.team =`/team/dashboard/jobs/${self.task.id}/comments/delete/${comment.id}`
            self.endpoints.client = `/client/dashboard/jobs/${self.task.id}/comments/delete/${comment.id}`
            axios.delete(self.guardedLocation())
            .then((response) => {

                if(comment.parent_id == null) {
                    self.$delete(self.comments, commentIndex)
                    self.$popup({ message: 'Thread Deleted!', backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                    
                }
                else{
                    self.$delete(self.comments[commentIndex].children, childIndex)
                    self.$popup({ message: 'Comment Deleted!', backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                }
            })
            .catch(error => {
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
            
        }
    },
    watch: {
        
    },

}
</script>