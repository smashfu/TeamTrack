<!-- New Task Modal -->
<div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    {!! Form::open(['action' => 'TasksController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        {{Form::label('sprintId', 'Sprint Id')}}
                        {{Form::text('sprintId', 9, ['class' => 'form-control', 'id'=>'sprint-id-text-field','placeholder' => 'Sprint Id'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('assignedTo', 'Assign Task to')}}
                        {{Form::select('assignedTo', ['12'=>'12'], null, ['class' => 'form-control', "placeholder" => "Pick member"])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('title', 'Task Name')}}
                        {{Form::text('title', 'Default Title', ['class' => 'form-control', 'placeholder' => 'Task Name'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('description', 'Task Description')}}
                        {{Form::textarea('description', 'Default Description', ['class' => 'form-control', 'placeholder' => 'Task Description'])}}
                    </div>
                <div class="modal-footer">
                    {{Form::submit('Add Task', ['class'=>'btn btn-primary new-task-submit', 'data-dismiss'=>'modal'])}}
                </div>
                
            </div>
        </div>
    {!! Form::close() !!}
</div>