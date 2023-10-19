@extends('layout.baseview')
@section('title','All Tasks')
@section('style')
<style> 
    .done{
        text-decoration: line-through;
    }
</style>
@endsection
@section('content')
@include('layout.navigation')
<div class="container mt-5">
    <button class="btn btn-outline-primary mb-5 end-0" onclick="addTask()">
        Add Tasks
    </button>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sl no.</th>
                        <th scope="col">Task Description</th>
                        <th scope="col">Task Owner</th>
                        <th scope="col">Task ETA</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="taskTable">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Task</h5>
                <button class="bi bi-x-lg" type="button" onclick="hideTask()"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <label for="createTaskDiscription">Task Description</label>
                        <input type="text" class="form-control" id="createTaskDiscription" placeholder="Enter Task Discription">
                    </div>
                    <div class="form-group">
                        <label for="createTaskOwner">Task Owner Name</label>
                        <input type="text" class="form-control" id="createTaskOwner" placeholder="Enter Task Owner Name">
                    </div>
                    <div class="form-group">
                        <label for="createTaskOwnerEmail">Task Owner Email</label>
                        <input type="text" class="form-control" id="createTaskOwnerEmail" placeholder="Enter Task Owner Email ID">
                    </div>
                    <div class="form-group">
                        <label for="createTaskETA">Task ETA</label>
                        <input type="date" class="form-control" id="createTaskETA" placeholder="Enter Task ETA">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideTask()">Close</button>
                <button type="button" class="btn btn-primary" onclick="createTask()">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button class="bi bi-x-lg" type="button" onclick="hideTask()"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <label for="editTaskDiscription">Task Description</label>
                        <input type="text" class="form-control" id="editTaskDiscription" placeholder="Enter Task Discription">
                    </div>
                    <div class="form-group">
                        <label for="editTaskOwner">Task Owner Name</label>
                        <input type="text" class="form-control" id="editTaskOwner" placeholder="Enter Task Owner Name">
                    </div>
                    <div class="form-group">
                        <label for="editTaskOwnerEmail">Task Owner Email Id</label>
                        <input type="text" class="form-control" id="editTaskOwnerEmail" placeholder="Enter Task Owner Email ID">
                    </div>
                    <div class="form-group">
                        <label for="editTaskETA">Task ETA</label>
                        <input type="date" class="form-control" id="editTaskETA" placeholder="Enter Task ETA">
                    </div>
                    <div class="form-group">
                        <label for="editTaskStatus">Task Status</label>
                        <select name="" id="editTaskStatus" class="form-control">
                            <option>Set Task Status</option>
                            <option value="0">In Progress</option>
                            <option value="1">Done</option>
                        </select>
                    </div>
                    <input type="hidden" id="editTaskid">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideTask()">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateTask()">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="doneTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mark Task as Done</h5>
                <button class="bi bi-x-lg" type="button" onclick="hideTask()"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure to mark as done?</p>
                    <input type="hidden" id="doneTaskid">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideTask()">No</button>
                <button type="button" class="btn btn-primary" onclick="updateMarkAsDoneTask()">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Task</h5>
                <button class="bi bi-x-lg" type="button" onclick="hideTask()"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete this task?</p>
                    <input type="hidden" id="deleteTaskid">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideTask()">No</button>
                <button type="button" class="btn btn-primary" onclick="updateTaskDelete()">Yes</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<script>
    $(document).ready(function(){
        getAllTasks();
    });
    function getAllTasks(){
        jQuery.ajax({
            type: 'get',
            url: 'http://localhost:8000/api/task',
            success: function(result){
                var html ='';
                for(var i=0;i<result.length;i++){
                    var lineThrough = result[i]['status'] == 1?'class="done"' : "";
                    html +='<tr>'
                            +'<th scope="row"'+lineThrough+'>'+(i+1)+'.</th>'
                            +'<td '+lineThrough+'>'+result[i]['task_description']+'</td>'
                            +'<td '+lineThrough+'>'+result[i]['task_owner']+'</td>'
                            +'<td '+lineThrough+'>'+result[i]['task_eta']+'</td>'
                            +'<td>'
                                +'<i class="bi bi-pencil-square" onclick="editTask('+result[i]['id']+')"></i>'
                                    +'<i class="bi bi-check2-square" onclick="markasdone('+result[i]['id']+')"></i>'
                                    +'<i class="bi bi-trash" onclick="deleteTask('+result[i]['id']+')"></i>'
                                +'</td>'
                        +'</tr>'
                }
                $("#taskTable").html(html)
            },
            error:function(e){
                console.log(e.responseText)
            }
        });
    }
    function addTask(){
        jQuery.noConflict();
        $("#createTaskModal").modal('show');
    }
    function hideTask(){
        jQuery.noConflict();
        $("#createTaskModal").modal('hide');
        $("#editTaskModal").modal('hide');
        $("#doneTaskModal").modal('hide');
        $("#deleteTaskModal").modal('hide');
    }
    function createTask(){
        var task_description = $("#createTaskDiscription").val();
        var task_owner = $("3createTaskOwner").val();
        var task_owner_email = $("#createTaskOwnerEmail").val();
        var task_eta = $("#createTaskETA").val();
        jQuery.ajax({
            type: 'post',
            url: 'http://localhost:8000/api/task',
            data:{
                task_description:task_description,
                task_owner:task_owner,
                task_owner_email:task_owner_email,
                task_eta:task_eta
            },
            success: function(result){
                jQuery.noConflict();
                $('#createTaskModal').modal('hide');
                getAllTasks();
            },
            error:function(e){
                console.log(e.responseText)
            }
        });
    }
    function editTask(id){
        jQuery.ajax({
            type: 'get',
            url: 'http://localhost:8000/api/task/'+id,
            success: function(result){
                $("#editTaskDiscription").val(result['task_description']);
                $("#editTaskOwner").val(result['task_owner']);
                $("#editTaskOwnerEmail").val(result['task_owner_email']);
                $("#editTaskETA").val(result['task_eta']);
                $("#editTaskStatus").val(result['status']);
                $("#editTaskid").val(result['id']);
                jQuery.noConflict();
                $("#editTaskModal").modal('show');
            },
            error: function(e){
                console.log(e.responseText)
            }
        });
    }
    function updateTask(){
        var id = $("#editTaskid").val();
        var task_description = $("#editTaskDiscription").val();
        var task_owner = $("#editTaskOwner").val();
        var task_owner_email = $("#editTaskOwnerEmail").val();
        var task_eta = $("#editTaskETA").val();
        var task_status = $("#editTaskStatus").val();
        jQuery.ajax({
            type: 'put',
            url: 'http://localhost:8000/api/task/'+id,
            data:{
                task_description:task_description,
                task_owner:task_owner,
                task_owner_email:task_owner_email,
                task_eta:task_eta,
                task_status:task_status
            },
            success: function(result){
                jQuery.noConflict();
                $('#editTaskModal').modal('hide');
                getAllTasks();
            },
            error:function(e){
                console.log(e.responseText)
            }
        });
    }
    function markasdone(id){
        jQuery.noConflict();
        $("#doneTaskid").val(id);
        $("#doneTaskModal").modal('show');
    }
    function updateMarkAsDoneTask(){
        var id = $("#doneTaskid").val();
        jQuery.ajax({
            type: 'post',
            url: 'http://localhost:8000/api/task/done/'+id,
            success: function(result){
                jQuery.noConflict();
                $('#doneTaskModal').modal('hide');
                getAllTasks();
            },
            error:function(e){
                console.log(e.responseText)
            }
        });
    }
    function deleteTask(id){
        jQuery.noConflict();
        $("#deleteTaskid").val(id);
        $("#deleteTaskModal").modal('show');
    }
    function updateTaskDelete(){
        var id = $("#deleteTaskid").val();
        jQuery.ajax({
            type: 'delete',
            url: 'http://localhost:8000/api/task/'+id,
            success: function(result){
                jQuery.noConflict();
                $('#deleteTaskModal').modal('hide');
                getAllTasks();
            },
            error:function(e){
                console.log(e.responseText)
            }
        });
    }
</script>
@endsection