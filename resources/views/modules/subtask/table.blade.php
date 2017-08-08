<div class="row cells">
    <div class="cell">
        <div class="panel widget-box " data-role="panel">
            <div class="heading">
                <div class="title">Subtasks</div>
            </div>
            <div class="content">
                <div class="sub-heading bg-chess">
                    <a @click="showAddSubtaskModal()">
                    <button class="button info"><span class="mif-plus"></span> Add Subtask</button>
                    </a>
                </div>
                <div class="text">

                    <div class="table-responsive ">

                        <table class="table border bordered striped ">
                            <thead class="">
                                <tr>
                                    <th>Subtask</th>
                                    <th>Points</th>
                                    <th>Priority</th>
                                    <th>Video</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Assigned To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody v-for="(subtask, subtaskKey) in subtasks">
                                <tr>
                                    <td>@{{ subtask.name }}</td>
                                    <td class="align-center">@{{ subtask.points }}</td>
                                    <td class="align-center">
                                        <span class="icon mif-star-full fg-amber" v-for="(priority, priorityKey) in parseInt(subtask.priority)">
                                        </span>
                                    </td>
                                    <td class="align-center">
                                        <span class="tag info" style="cursor: pointer;">
                                            <span class="icon mif-play" @click="viewVideoLink(subtask)">
                                            </span>
                                        </span>
                                    </td>
                                    <td class="align-center">
                                        <span class="tag bg-green fg-white" v-if="subtask.done">Done
                                        </span>
                                        <span class="tag bg-amber fg-white" v-else>Ongoing
                                        </span>
                                    </td>
                                    <td>
                                    @{{ subtask.due_date | date }}
                                    </td>
                                    <td>
                                        <span class="tag bg-blue fg-white" v-for="(employee,employeeKey) in subtask.employees">@{{ employee.name }}
                                        </span>
                                    </td>
                                    <td class="align-center" style="font-size: 1.25rem">
                                        <span class="fg-lightBlue icon mif-pencil" @click="editSubtask(subtask)" style="cursor:pointer;"
                                        data-role="hint" data-hint-mode="2" :data-hint="`Edit Subtask:|${subtask.name}`" data-hint-position="top"
                                        >
                                        </span>
                                        <span class="fg-red icon fa fa-trash" @click="deleteSubtask(subtask)" style="cursor:pointer;"
                                        data-role="hint" data-hint-mode="2" :data-hint="`Delete Subtask:|${subtask.name}`" data-hint-position="top"
                                        >
                                        </span>

                                        <span class="tag" :class="{success: !subtask.done}" @click="toggleDone(subtask)" style="cursor:pointer;"
                                        data-role="hint" data-hint-mode="2" data-hint="Toggle|Done/Undone Subtask" data-hint-position="top"
                                        >
                                            <span class="icon mif-checkmark" v-if="!subtask.done">
                                            </span>
                                            <span class="fg-amber icon mif-blocked" v-else>
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
