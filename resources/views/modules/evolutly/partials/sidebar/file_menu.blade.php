<!-- File Menu -->
<li class="{{ (Request::segment(1)=='files'?'active-container':'') }}">
    <a href="#" class="dropdown-toggle">
        <span class="mif-images icon fg-lightOrange"></span>
        <span class="title fg-amber">Uploads</span>
        <span class="counter">Manage Uploads</span>
    </a>
    <ul class="d-menu" data-role="dropdown" style="{{ (in_array(Request::segment(2),['/','upload'])?'display:block':'') }}">
        <!-- File Link -->
        <li class="{{ (Request::segment(2)=='/'?'active':'') }}">
            <a href="/files" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">File Management</span>
                <span class="counter">Manage Files</span>
            </a>
        </li>
        <!-- Upload Link -->
        <li class="{{ (Request::segment(2)=='upload'?'active':'') }}">
            <a href="/files/upload" class="">
                <span class="mif-chevron-right icon"></span>
                <span class="title">Upload Files</span>
                <span class="counter">Drag n Drop file upload</span>
            </a>
        </li>
    </ul>
</li>