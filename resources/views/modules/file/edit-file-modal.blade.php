<modal name="edit-file-modal">
        <div class="panel widget-box">
            <div class="heading">
                <div class="title">Edit @{{fileEditForm.name}} <span @click="closeEditFileModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
            </div>
            <div class="content">
                <form @submit.prevent="editFile()" role="form" class="padding10">
                    <div class="row">
    
                        <div class="input-control text full-size">
                            <input type="text" placeholder="Edit" v-model="fileEditForm.name">
                            <button type="submit" class="button info" :disabled="fileEditForm.busy">
                                <span class="icon mif-keyboard-return" v-if="fileEditForm.busy"></span>
                                <span class="icon mif-spinner mif-ani-spin" v-else></span>
                        </button>
                        </div>
                        
                    </div>
                    <div class="row align-center">
                        <span class="fg-red" style="margin-top:150px;" v-show="fileEditForm.errors.has('name')">
                                    @{{ fileEditForm.errors.get('name') }}
                        </span>
                    </div>
                </form>
            </div>
        </div>
</modal>