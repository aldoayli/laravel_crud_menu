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
                            <th>id</th>
                            <th>Parent Menu</th>
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
                <label><b>parent_id</b></label>
                <div id='view_parent_id'></div>
              </div>
              <hr>
          </div>
          <div class="col-sm-12">
              <div class="form-group">
                <label><b>menu</b></label>
                <div id='view_menu'></div>
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
            <div class="form-group">
              <label for="parent">parent menu</label>
              <select class="form-control" name="parent" id="parent" required="">   
              	                      
              </select>
              <div class="invalid-feedback">Field is required</div>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="menu-group">
              <label for="menu">menu</label>
			  <input type="text" class="form-control" name="menu" id="menu" required="">
              <div class="invalid-feedback">Field is required</div>
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
                url: '{{ url("manage-menu-data") }}',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: 'POST',
            },
            columns: [
              {data: 'action', name: 'action', orderable: false, searchable: false },
              // {data: 'id', name: 'id'},
              {data: 'id', name: 'id'},
              //{data: 'parent', name: 'Parent Menu'},
              {
                  data: 'parent',
                  name: 'Parent Menu',
                  render: function(data, type, row) {
                    if(row.parent==null){
                       return '[ Parent Menu ]';
                    } 
                    else {
                       return data;
                    }
                  }
              },
              {data: 'menu', name: 'Menu'},              
            ],
             columnDefs: [
                  { width: '10%', targets: 0 },
             ],
        });

        $('#myTables tbody').on( 'click', '.view-modal', function () {
          //reset view

            var d = oTable.row( $(this).parents('tr') ).data();

            $('#view_id').html(d.id).text();
            $('#view_parent_id').html(d.parent_id).text();
            $('#view_menu').html(d.menu).text();

            $('.modal-title').text();
            $('.modal-title').text('View');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').addClass('modal-lg');

            $('#myModalview').modal('show');

        });


        $('.add-modal').on( 'click', function () {


            $('#id').val('');
            $('#parent_id').val('');
            $('#menu').val('');

            $('#footer_action_button').text(" Add");
            $('.actionBtn').addClass('btn-primary');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('add');
            $('.actionBtn').removeClass('edit');
            $('.actionBtn').removeClass('delete');
            $('.modal-title').text('Add');
            $('input[name=button_action]').val('insert');

            $('#parent').find('option').remove();
            $('<option>').val('0').text('[ Parent Menu ]').appendTo('#parent');
            $.ajax({
                type: 'post',
                url: '{{ url("get-parent-menu") }}',
                dataType: "json",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
        					$.each(data, function(k, v) {
        					    $('<option>').val(v.id).text(v.menu).appendTo('#parent');
        					});
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

            $('#id').val(d.id);
            $('#parent_id').val(d.parent_id);
            $('#menu').val(d.menu);

            $('#parent').find('option').remove();
            $('<option>').val('0').text('[ Parent Menu ]').appendTo('#parent');
            $.ajax({
                type: 'post',
                url: '{{ url("get-parent-menu") }}',
                dataType: "json",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                  $.each(data, function(k, v) {
                      
                      if(v.id == d.parent_id){
                        $('<option>').val(v.id).text(v.menu).attr('selected', true).appendTo('#parent');
                      } else {
                        
                        $('<option>').val(v.id).text(v.menu).appendTo('#parent');
                      }
                  });
                },
                error: function(data){
                    alert('Error ! please refresh page and try again.');
                    console.log(data);
                }
            });



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
              url: '{{ url("manage-menu-edit") }}',
              dataType: "json",
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
              data: {
                'parent_id': $('#parent').val(),
                'menu': $('#menu').val(),
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
              url: '{{ url("manage-menu-edit") }}',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
              data: {
              	'id': $('#id').val(),
                'parent_id': $('#parent_id').val(),
                'menu': $('#menu').val(),
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
            url: '{{ url("manage-menu-delete") }}',
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

@endsection

