<div class="">
    <ul class="breadcrumbs fg-amber dark bg-teal" v-if="guard === 'employee'">
        <li><a href="/team/dashboard"><span class="icon mif-widgets fg-white"></span></a></li>
        <li><a href="/team/dashboard/projects/{{ $project->id }}">@{{ project.name }}</a></li>
    </ul>
    <ul class="breadcrumbs fg-amber dark bg-teal" v-else-if="guard === 'client'">
        <li><a href="/client/dashboard"><span class="icon mif-widgets fg-white"></span></a></li>
        <li><a href="/client/dashboard/projects/{{ $project->id }}">@{{ project.name }}</a></li>
    </ul>
    <ul class="breadcrumbs fg-amber dark bg-teal" v-else>
        <li><a href="/dashboard"><span class="icon mif-widgets fg-white"></span></a></li>
        <li><a href="/dashboard/projects/{{ $project->id }}">@{{ projectForm.project_name }}</a></li>
    </ul>
</div>