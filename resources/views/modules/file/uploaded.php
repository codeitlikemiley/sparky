<div class="frame" id="uploaded_tab">
        <!-- Uses Vue Component file-upload -->
    <uploaded-files :tenant="tenant" :guard="guard"  inline-template>
        <div>
            <div class="section-wrapper align-center fg-white">
                <h3 v-show="files.length >0">Manage Your Uploads</h3>
            </div>
            <div v-if="files.length >0" class="section-wrapper animated fadeInRightBig">
                <div class="grid">
                    <div class="row cells3" v-for="item in fileChunks(files)">
                        <div class="cell gallery" v-for="file in item">
                            <div class="image">
                                <div class="image-inner crop">
                                        <a :href="getSourceFile(file)">
                                            <img  :src="getImageByExtension(file)" alt="" class="portrait"/>
                                        </a>
                                        <p class="image-caption">
                                                {{ file.name }}
                                        </p>
                                    
                                </div>
                                <div class="image-info">
                                    <h5 class="title">{{ file.name }}</h5>
                                    <div class="row">
                                        <span>Uploaded By: </span> <a style="cursor:pointer;">  {{ file.uploadable.name }}</a>
                                    </div>
                                    <div class="row cells2" style="min-height:35px; padding-top:5px;cursor:pointer;">
                                        <div class="cell bg-blue align-center sub-alt-header" @click="editFile(file)">
                                            <a href="#!" class="fg-white" style="vertical-align:middle;">
                                                <span class="mif-pencil"></span> Edit
                                            </a>
                                        </div>
                                        <div class="cell bg-red align-center sub-alt-header" @click="deleteFile(file)">
                                            <a href="#!" class="fg-white" style="vertical-align:middle;">
                                                <span class="mif-bin"></span> Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="align-center v-align-middle">
                <h1 class="fg-white">No Files Uploaded Yet.</h1>
            </div>
        </div>
    </uploaded-files>
</div>