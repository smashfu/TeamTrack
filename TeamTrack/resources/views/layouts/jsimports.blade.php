<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
<script src="{{ asset('template/scripts/extras.1.1.0.min.js') }}"></script>
<script src="{{ asset('template/scripts/shards-dashboards.1.1.0.min.js') }}"></script>
<script src="{{ asset('template/scripts/app/app-blog-overview.1.1.0.js') }}"></script>


<script type="text/javascript">

          $.ajaxSetup({
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
          });

          document.onload = initializeFunctions();

          function initializeFunctions()
          {
               setSidebar();
               newSprint();
               setSprintId();
               newTask();
               editTask();
               newMember();
               deleteTask();
               setEditTaskModalInfo();
          }


          function setSidebar()
          {
               
               $(".sidebar-link").off('click').click(function(e){
                    console.log('setSidebar called');
                    e.preventDefault();
                    // Load the content from the link's href attribute
                    $('.content').load( $(this).attr('href').concat(' .content'), function(responseText, textStatus, XMLHttpRequest){
                         initializeFunctions();
                              // newSprint();
                              // newMember();
                              // newTask();
                              // editTask();
                              // setSprintId();
                              // setEditTaskModalInfo();
                              // deleteTask();
                         });

                    //Change window location
                    //window.location.replace($(this).attr('href'));
                    window.history.pushState('', 'Title', $(this).attr('href'));
               });
          }
          



          function setSprintId()
          {
               console.log('setSprintId');
               $(".add-task-modal").off('click').click(function(e){
                    console.log("setSprintId called");
                    document.getElementById("sprint-id-text-field").value = $(this).attr('href');
               });
          }



          function setEditTaskModalInfo()
          {
               $(".edit-task-modal").off('click').click(function(e){

                    taskId = $(this).attr('taskId');
                    sprintId = e.target.parentElement.parentElement.querySelector('#taskSprintId').innerHTML;
                    assignedTo = e.target.parentElement.parentElement.querySelector('#taskAssignedToId').innerHTML;
                    title = e.target.parentElement.parentElement.querySelector('#taskTitle').innerHTML;
                    description = e.target.parentElement.parentElement.querySelector('#taskDescription').innerHTML;
                    console.log('setEditTaskModalInfo called. task: '.concat(taskId));

                     document.getElementById("sprint-id-text-field2").value = sprintId;
                     document.getElementById("task-id-text-field").value = taskId;
                     document.getElementById("assigned-to-field").value = assignedTo;
                     document.getElementById("title-text-field").value = title;
                     document.getElementById("description-text-field").value = description;
               });
          }
          
          function editTask()
          {
               $(".edit-task-submit").off('click').click(function(e){
                    e.preventDefault();
                    console.log('editTask called');

                    var sprintId = $("input[name=sprintId2]").val();
                    var taskId = $("input[name=taskId2]").val();
                    var assignedTo = $("select[name=assignedTo2]").val();
                    var title = $("input[name=title2]").val();
                    var description = $("textarea[name=description2]").val();

                    $.ajax({
                    type:'PUT',
                    url:'/tasks/'.concat(taskId),
                    data:{sprintId:sprintId, assignedTo:assignedTo, title:title, description:description},
                    success:function(data){
                         $('.sprint-view').load( window.location.pathname.concat(' .sprint-view'),function(responseText, textStatus, XMLHttpRequest){
                              setSprintId();
                              setEditTaskModalInfo();
                              deleteTask();
                         });
                         console.log(data.message);
                    } 
                    });
               });
          }

          function newTask()
          {
               //console.log('newTask');
               $(".new-task-submit").off('click').click(function(e){
                    e.preventDefault();

                    console.log('newTask called');
                    var sprintId = $("input[name=sprintId]").val();
                    var taskId = $("input[name=taskId]").val();
                    var assignedTo = $("select[name=assignedTo]").val();
                    var title = $("input[name=title]").val();
                    var description = $("textarea[name=description]").val();

                    $.ajax({
                    type:'POST',
                    url:'/tasks/create',
                    data:{sprintId:sprintId, assignedTo:assignedTo, title:title, description:description},
                    success:function(data){
                          $('.sprint-view').load( window.location.pathname.concat(' .sprint-view'),function(responseText, textStatus, XMLHttpRequest){
                              setSprintId();
                              setEditTaskModalInfo();
                              deleteTask();
                         });
                    } 
                    });
               });
          }

          function deleteTask()
          {
               //console.log('deleteTask');
               $(".delete-task").off('click').click(function(e){
                    e.preventDefault();
                    console.log("Delete task called : ".concat($(this).attr('href')));
                    //console.log("Delete task sprint: ".concat($(this).attr('sprint')));
                    sprintId = $(this).attr('sprint');

                    $.ajax({
                    type:'DELETE',
                    url: '/tasks/'.concat( $(this).attr('href') ),
                    success:function(data){
                         $('.sprint-view').load( window.location.pathname.concat(' .sprint-view'),function(responseText, textStatus, XMLHttpRequest){
                              setSprintId();
                              setEditTaskModalInfo();
                              deleteTask();
                         });
                         console.log(data.message);  
                         console.log(window.location.pathname);
                    } 
                    });
               });
          }

          

          function newSprint()
          {
               //console.log('newSprint');
               $(".new-sprint-submit").off('click').click(function(e){
                    e.preventDefault();

                    console.log("newSprint called");

                    $.ajax({
                    type:'POST',
                    url:'/sprints',
                    success:function(data){
                         console.log(window.location.pathname);
                         //console.log(data.message);
                         //location.reload();
                         $('.sprint-view').load( window.location.pathname.concat(' .sprint-view'),function(responseText, textStatus, XMLHttpRequest){
                              setSprintId();
                              setEditTaskModalInfo();
                              deleteTask();
                         });

                    } 
                    });
               });
          }


          function newMember()
          {
               //console.log('newMember');
               $(".new-member-submit").off('click').click(function(e){
                    e.preventDefault();

                    console.log("newMember called");
                    var email = $("input[name=email]").val();

                    $.ajax({
                    type:'POST',
                    url:'/members',
                    data:{email:email},
                    success:function(data){
                         console.log(window.location.pathname);
                         console.log(data.message);
                         $('.team-member').load( window.location.pathname.concat(' .team-member') );
                    } 
                    });
               });
          }
          


     </script>