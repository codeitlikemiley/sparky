<div class="frame" id="files_tab">
    <form @submit.prevent="uploadFile(project.id)" role="form" enctype="multipart/form-data">
        <div class="cell">
            <div style="height: 100px;">
                <!-- Add View Here to List All Assigned Employee in a Task -->
            </div>
            <div class="input-control file full-size" data-role="input">
                <input id="file" type="file" style="z-index: 0;" tabindex="-1">
                <input type="text" class="input-file-wrapper" readonly="" style="z-index: 1; cursor: default;display:none;">
                <button class="button" type="button"><span class="mif-folder"></span></button>
            </div>
            <div class="align-right">
                <button type="submit" class="button info">
                    <span class="mif-upload">
                    </span> Upload
                </button>
            </div>
            <div style="height: 100px;">
            </div>
        </div>
    </form>
</div>