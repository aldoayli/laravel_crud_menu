@extends('layouts.app')

@section('content')
@parent
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <div class="row">
                <div class="col-sm-8">
                  <h4>{{ $title }}</h4>
                </div>
                <div class="col-sm-4">
                    <a class="float-right btn btn-sm btn-info d-sm-down-none add-modal">Add</a>
                </div>
              	</div>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div id="form_output"></div>
                    <div class="table-responsive-lg table-responsive">
                      <table id="myTables" class="table table-sm table-responsive  table-hover nopadding" width='100%' style="width:100%">
                        <thead class="">
                          <tr>
                            <th class="text-center" width="100px" style="width: 100px !important;"></th>
                            <th>ID</th>
                            <th>Assign by</th>
                            <th>Assign to</th>
                            <th>Menu</th>
                          </tr>
                        </thead>
                      </table>

                    </div>
                  </div>
                  <!--/.col-->
                </div>
                <!--/.row-->
              </div>


            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModalview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">View</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="col-sm-12">
              <div class="form-group">
                <label><b>id</b></label>
                <div id='view_id'></div>
              </div>
              <hr>
          </div>
          <div class="col-sm-12">
              <div class="form-group">
                <label><b>Assign by</b></label>
                <div id='view_assign_by'></div>
              </div>
              <hr>
          </div>
          <div class="col-sm-12">
              <div class="form-group">
                <label><b>assign to</b></label>
                <div id='view_assign_to'></div>
              </div>
              <hr>
          </div>     
          <div class="col-sm-12">
              <div class="form-group">
                <label><b>menu</b></label>
                <div id='view_menu_id'></div>
              </div>
              <hr>
          </div>  

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <font class=''> Close </font>
        </button>
      </div>
    </div>

  </div>
</div>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="editContent">
        <form class="form-horizontal" name="form-horizontal" role="form">
          
          {{csrf_field()}}
          <div class="col-sm-12">
            <div class="form-group" id="showiddiv">
              <input type="hidden" class="form-control" name="id" id="id">
            </div>
          </div>

          <div class="col-sm-12">
            <div class="menu-group">
              <label for="assign_by">assign by</label>
              <input type="text" class="form-control" value="{{ $assign_by_email }}" disabled="">
              <input type="hidden" class="form-control" name="assign_by" id="assign_by" required="">
              <div class="invalid-feedback">Field is required</div>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="menu-group">
              <label for="assign_to">assign to</label>

              <select class="form-control" name="assign_to" id="assign_to" required="">                         
              </select>
              <div class="invalid-feedback">Field is required</div>


            </div>
          </div>

          <div class="col-sm-12">
            <div class="menu-group">
              <label for="menu">menu</label>
			        <input type="hidden" class="form-control" name="menu_id" id="menu_id" required="">
              <div class="invalid-feedback">Field is required</div>

              <div>
   

              <div id="tree"></div>
              </div>

            </div>
          </div>

        </form>
        </div> 

        <div class="deleteContent">
          Are you sure you want to delete this data? <span class="hidden did"></span>
            <input type="hidden" class="form-control" name="deleteid" id="deleteid">
        </div>

      </div>



      <div class="modal-footer">
        <input type="hidden" name="button_action" id="button_action" value="insert" />
        <button type="button" class="btn actionBtn" data-dismiss="modal">
          <font id="footer_action_button" class=''> </font>
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <font class=''> Close </font>
        </button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {

    $(function() {
        var oTable = $('#myTables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("assign-menu-data") }}',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: 'POST',
            },
            columns: [
              {data: 'action', name: 'action', orderable: false, searchable: false },
              // {data: 'id', name: 'id'},
              {data: 'id', name: 'id'},
              {data: 'assign_by_email', name: 'Assign by'},
              {data: 'assign_to_email', name: 'Assign to'},   
              {data: 'menu_id', name: 'menu'},             
            ],
             columnDefs: [
                  { width: '10%', targets: 0 },
             ],
        });

        $('#myTables tbody').on( 'click', '.view-modal', function () {
          //reset view

            var d = oTable.row( $(this).parents('tr') ).data();

            $('#view_id').html(d.id).text();
            $('#view_assign_by').html(d.assign_by_email).text();
            $('#view_assign_to').html(d.assign_to_email).text();
            $('#view_menu_id').html(d.menu_id).text();

            $('.modal-title').text();
            $('.modal-title').text('View');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').addClass('modal-lg');

            $('#myModalview').modal('show');

        });


        $('.add-modal').on( 'click', function () {

           var list =''; 
           $('#tree').empty();
           var list =<?php echo $menu_list; ?>;

            var tree = simTree({
                el: '#tree',
                data: list,
                check: true,
                linkParent: true,

                //check: true,
                onClick: function (item) {
                    // console.log(item)
                },
                onChange: function (item) {
                    console.log(item);
                    var arr=[];
                    $('#menu_id').val('');
                  for (var i = 0; i < item.length; i++) {
                      if (typeof item[i]['children'] !== 'undefined' && item[i]['children'].length > 0) {
                          // the array is defined and has at least one element
                      } else {
                          arr.push(item[i]['id']);
                      }

                  }


                      var arrid = arr.join(",");
                      console.log(arrid);
                      $('#menu_id').val(arrid);
                    
                }
            });



            $('#id').val('');
            $('#assign_by').val('{{ $assign_by_id }}');
            $('#assign_to').val('');
            $('#menu_id').val('');

            $('#footer_action_button').text(" Add");
            $('.actionBtn').addClass('btn-primary');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('add');
            $('.actionBtn').removeClass('edit');
            $('.actionBtn').removeClass('delete');
            $('.modal-title').text('Add');
            $('input[name=button_action]').val('insert');

            $('#assign_to').find('option').remove();

              $.ajax({
                  type: 'post',
                  url: '{{ url("get-unassign-id") }}',
                  dataType: "json",
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  },
                  success: function(data) {
                    var x = 0;
          					$.each(data, function(k, v) {
          					    $('<option>').val(v.id).text(v.email).appendTo('#assign_to');
                        x++;
          					});
                    console.log(x);
                    if(x==0) {
                      alert('all user already got assign menu.');
                    }
                  },
                  error: function(data){
                      alert('Error ! please refresh page and try again.');
                      console.log(data);
                  }
              });


            $('.deleteContent').hide();
            $('.editContent').show();

            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').addClass('modal-lg');
            $('#myModal').modal('show');

        });

        $('#myTables tbody').on( 'click', '.edit-modal', function () {
            var d = oTable.row( $(this).parents('tr') ).data();



           var list =''; 
           $('#tree').empty();
           var list =<?php echo $menu_list; ?>;
           // var list = [{"id":1,"pid":0,"name":"Home","checked":"checked","expand":"expand"},{"id":4,"pid":0,"name":"Contact"},{"id":2,"pid":1,"name":"About","checked":"checked","expand":"expand"},{"id":3,"pid":2,"name":"Products","checked":"checked","expand":"expand"},{"id":5,"pid":2,"name":"Services","checked":"checked","expand":"expand"}];
           //console.log(list);
            // mapping assign menu from database
            $.ajax({
                type: 'post',
                url: '{{ url("get-tree-menu") }}',
                dataType: "json",
                data : {
                  id:d.menu_id,
                },
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {

                  //var list = data;
                  console.log(data);
                },
                error: function(data){
                    alert('Error ! please refresh page and try again.');
                    console.log(data);
                }
            });


            var tree = simTree({
                el: '#tree',
                data: list,
                check: true,
                linkParent: true,

                //check: true,
                onClick: function (item) {
                    // console.log(item)
                },
                onChange: function (item) {
                    console.log(item);
                    var arr=[];
                    $('#menu_id').val('');

                      for (var i = 0; i < item.length; i++) {
                          if (typeof item[i]['children'] !== 'undefined' && item[i]['children'].length > 0) {
                              // the array is defined and has at least one element
                          } else {
                              arr.push(item[i]['id']);
                          }

                      }
                      var arrid = arr.join(",");
                      console.log(arrid);
                      $('#menu_id').val(arrid);
                    
                }
            });




            $('#assign_to').find('option').remove();
              $('<option>').val(d.assign_to).text(d.assign_to_email).attr('selected', true).appendTo('#assign_to');
              $.ajax({
                  type: 'post',
                  url: '{{ url("get-unassign-id") }}',
                  dataType: "json",
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  },
                  success: function(data) {
                    var x = 0;
                    $.each(data, function(k, v) {
                        $('<option>').val(v.id).text(v.email).appendTo('#assign_to');
                        x++;
                    });
                    //console.log(x);
                    if(x==0) {
                      alert('all user already got assign menu.');
                    }
                  },
                  error: function(data){
                      alert('Error ! please refresh page and try again.');
                      console.log(data);
                  }
              });

            $('#id').val(d.id);
            $('#assign_by').val('{{ $assign_by_id }}');
            $('#assign_to').val(d.assign_to);
            $('#menu_id').val(d.menu_id);

            $('#footer_action_button').text(" Update");
            $('.actionBtn').addClass('btn-primary');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('edit');
            $('.actionBtn').removeClass('add');
            $('.actionBtn').removeClass('delete');
            $('.modal-title').text('Edit');
            $('input[name=button_action]').val('update');
            
            $('.deleteContent').hide();
            $('.editContent').show();

            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').addClass('modal-lg');
            $('#myModal').modal('show');

        });


        $('#myTables tbody').on( 'click' , '.delete-modal', function () {
            var d = oTable.row( $(this).parents('tr') ).data();

            $('#deleteid').val(d.id);

            $('#footer_action_button').text(" Delete");
            $('.actionBtn').addClass('btn-danger');
            $('.actionBtn').removeClass('btn-primary');
            $('.actionBtn').addClass('delete');
            $('.actionBtn').removeClass('add');
            $('.actionBtn').removeClass('edit');
            $('.modal-title').text('Delete');

            
            $('.editContent').hide();
            $('.deleteContent').show();

            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-sm');
            $('#myModal').modal('show');

        });
    });



    //action


    

    $('.modal-footer').on('click', '.add', function(event) {

      'use strict';

      var forms = document.getElementsByClassName('form-horizontal');
      var validation = Array.prototype.filter.call(forms, function(form) {

        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        } else {

          $.ajax({
              type: 'post',
              url: '{{ url("assign-menu-edit") }}',
              dataType: "json",
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
              data: {
                'assign_by': $('#assign_by').val(),
                'assign_to': $('#assign_to').val(),
                'menu_id': $('#menu_id').val(),
                button_action: $('#button_action').val(),

              },
              success: function(data) {
                  $('#form_output').html('');
                  $('#myTables').DataTable().ajax.reload();
                  if(data.error.length > 0)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_output').html(error_html);
                    }
                  else
                    {
                        $('#form_output').html(data.success);
                    }
              },
              error: function(data){
                  alert('Error ! please refresh page and try again.');
                  console.log(data);
              }
          });


        }
        form.classList.add('was-validated');

      });



    });


    $('.modal-footer').on('click', '.edit', function() {
      'use strict';

      var forms = document.getElementsByClassName('form-horizontal');
      var validation = Array.prototype.filter.call(forms, function(form) {

        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        } else {

          $.ajax({
              type: 'post',
              dataType: 'json',
              url: '{{ url("assign-menu-edit") }}',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
              data: {
              	'id': $('#id').val(),
                'assign_by': $('#assign_by').val(),
                'assign_to': $('#assign_to').val(),
                'menu_id': $('#menu_id').val(),
                button_action: $('#button_action').val(),
              },
              success: function(data) {
                  $('#form_output').html('');
                  $('#myTables').DataTable().ajax.reload();
                  if(data.error.length > 0)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_output').html(error_html);
                    }
                  else
                    {
                        $('#form_output').html(data.success);
                    }
              },
              error: function(data){
                  alert('Error ! please refresh page and try again.');
                  console.log(data);
              }
          });

        }
        form.classList.add('was-validated');
      });

    });


    $('.modal-footer').on('click', '.delete', function() {
        var del = $('#deleteid').val();
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '{{ url("assign-menu-delete") }}',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data:{id:del},
            success: function(data) {
                $('#form_output').html('');
                $('#myTables').DataTable().ajax.reload();
                if(data.error.length > 0)
                  {
                      var error_html = '';
                      for(var count = 0; count < data.error.length; count++)
                      {
                          error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                      }
                      $('#form_output').html(error_html);
                  }
                else
                  {
                      $('#form_output').html(data.success);
                  }
            },
            error: function(data){
                alert('Error ! please refresh page and try again.');
                console.log(data);
            }
        });
    });




});
</script>

    <script>
 

    </script>

@endsection

