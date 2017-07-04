@extends('evolutly::layouts.app')
@push('critical_css')
@include('css::grid')
@include('css::footer')
<style>
    .option-wrap {
        width: 110px;
    }

    .name-wrap {
        width: 220px;
    }

    .designation-wrap {
        width: 30%;
    }
</style>
@endpush @section('content')
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
                            <form action="{{ url('employees/table') }}" id="employeeTable" method="POST" data-page="1" data-ref="{{ url(" /employees
                                ")}}">
                                <button class="button small-button primary create-item">Add Employee</button>
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
                                            @foreach($employees as $employee)
                                            <tr>
                                                <td>{{$employee->name}}</td>
                                                <td class="align-left">{{$employee->email}}</td>
                                                <td class="align-left">
                                                    @foreach($employee->projects as $project)
                                                    <span class="tag info">
                                                        <span class="icon mif-tag"></span>                                                    {{ $project->name }}
                                                    </span>
                                                    @endforeach
                                                </td>
                                                <td class="align-left">
                                                    <span class="tag success">
                                                        <span class="icon mif-eye">
                                                           
                                                        </span>
                                                    </span>
                                                    <span class="tag info">
                                                        <span class="icon mif-pencil">
                                                            
                                                        </span>
                                                    </span>
                                                    <span class="tag alert">
                                                        <span class="icon fa fa-trash">
                                                            
                                                        </span>
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>




@endsection @push('footer_js')
<script type="application/javascript">
    register_tabs_cmd({
        button_class: 'group-item',
        tabs_title: 'group',
        content_id: 'group_item',
        ref_action: 'setgroup',
        close_class: 'close-group'
    })
    register_save_button({
        button_class: 'save-group',
        close_class: 'close-group',
        target_table: '#groupTable',
        source_form: '#form_group'
    })

</script>
@endpush