Dear {($data->task_owner)},<br><br>

The task {($data->task_description)},<br><br> {($data->status == 0?"has ben added for you":"has been marked as completed")}

@if($data->task_eta == 0)
kindly complete it within {($data->task_eta)},<br><br>
@endif

Thank you