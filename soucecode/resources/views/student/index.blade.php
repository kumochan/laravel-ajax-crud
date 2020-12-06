@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-11">
                <h2>Laravel 7 Ajax CRUD Example</h2>
        </div>
        <div class="col-lg-1">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addModal">Add</a>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
	<div class="row">
		Tim kiem <input type="search" name="txtSearch" id="txtSearch" /> <button type="button" id="btnSearch">Tim Kiem</button>
	</div>

	<table class="table table-bordered" id="studentTable">
		<thead>
		<tr>
			<th>id</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Address</th>
			<th width="280px">Action</th>
		</tr>
		</thead>
		<tbody>
		@foreach ($students as $student)
			<tr id="{{ $student->id }}">
				<td>{{ $student->id }}</td>
				<td class="first_name">{{ $student->first_name }}</td>
				<td class="last_name">{{ $student->last_name }}</td>
				<td>{{ $student->address }}</td>
				<td>
					<a data-id="{{ $student->id }}" class="btn btn-primary btnEdit">Edit</a>
					<a data-id="{{ $student->id }}" class="btn btn-danger btnDelete">Delete</a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	

<!-- Add Student Modal SPA: single page application-->
<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Student</h4>
      </div>
	  <div class="modal-body">
		<form id="addStudent" name="addStudent" action="{{ route('student.store') }}" method="post">
			@csrf
			<div class="form-group">
				<label for="txtFirstName">First Name:</label>
				<input type="text" class="form-control" id="txtFirstName" placeholder="Enter First Name" name="txtFirstName">
			</div>
			<div class="form-group">
				<label for="txtLastName">Last Name:</label>
				<input type="text" class="form-control" id="txtLastName" placeholder="Enter Last Name" name="txtLastName">
			</div>
			<div class="form-group">
				<label for="txtAddress">Address:</label>
				<textarea class="form-control" id="txtAddress" name="txtAddress" rows="10" placeholder="Enter Address"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Student Modal -->
<div id="updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Student</h4>
      </div>
	  <div class="modal-body">
		<form id="updateStudent" name="updateStudent" action="{{ route('student.update') }}" method="post">
			<input type="hidden" name="hdnStudentId" id="hdnStudentId"/>
			@csrf
			<div class="form-group">
				<label for="txtFirstName">First Name:</label>
				<input type="text" class="form-control" id="txtFirstName" placeholder="Enter First Name" name="txtFirstName">
			</div>
			<div class="form-group">
				<label for="txtLastName">Last Name:</label>
				<input type="text" class="form-control" id="txtLastName" placeholder="Enter Last Name" name="txtLastName">
			</div>
			<div class="form-group">
				<label for="txtAddress">Address:</label>
				<textarea class="form-control" id="txtAddress" name="txtAddress" rows="10" placeholder="Enter Address"></textarea>
			</div>
			<button type="button" id="btnEdit" class="btn btn-primary">Submit</button>
		</form>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	

<script>
  $(document).ready(function () {

	//Add the Student  
	$("#addStudent").validate({
		 rules: {
				txtFirstName: "required",
				txtLastName: "required",
				txtAddress: "required"
			},
			messages: {

			},
 
		 submitHandler: function(form) {
		  var form_action = $("#addStudent").attr("action");
		  $.ajax({
			  data: $('#addStudent').serialize(),
			  url: form_action,
			  type: "POST",
			  dataType: 'json',
			  success: function (data) {
			      console.log(data);

				  var student = '<tr id="'+data.id+'">';
				  student += '<td>' + data.id + '</td>';
				  student += '<td>' + data.first_name + '</td>';
				  student += '<td>' + data.last_name + '</td>';
				  student += '<td>' + data.address + '</td>';
				  student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
				  student += '</tr>';

				  console.log(student);

				  $('#studentTable tbody').prepend(student);
				  $('#addStudent')[0].reset();
				  $('#addModal').modal('hide');
			  },
			  error: function (data) {
			  }
		  });
		}
	});
  
 
    //When click edit student
    //   $('this').click(function(){
      $(document).on( 'click', '.btnEdit', function () {
          var student_id = $(this).attr('data-id');


          $.get('student/' + student_id +'/edit', function (data) {
              $('#updateModal').modal('show');
              $('#updateStudent #hdnStudentId').val(data.id);
              $('#updateStudent #txtFirstName').val(data.first_name);
              $('#updateStudent #txtLastName').val(data.last_name);
              $('#updateStudent #txtAddress').val(data.address);
          })
	  });

      // $('#studentTable .btnEdit').on('click', function () {
       //    var student_id = $(this).attr('data-id');
       //    alert(100);
      //
      //
       //    $.get('student/' + student_id +'/edit', function (data) {
       //        $('#updateModal').modal('show');
       //        $('#updateStudent #hdnStudentId').val(data.id);
       //        $('#updateStudent #txtFirstName').val(data.first_name);
       //        $('#updateStudent #txtLastName').val(data.last_name);
       //        $('#updateStudent #txtAddress').val(data.address);
       //    })
	  // });

        // $('.btnEdit').click(function () {
			// editStudent();
        // });

	  $('#btnEdit').on('click', function () {
          editStudent();
      });

      // edit ajax
	  var editStudent =  function (){
          console.log($('#updateStudent').serialize());
          var form_data = $(this).serialize();
          var id = $('#updateStudent #hdnStudentId').val();
          $.post('student/update',{
              'first_name': $('#updateStudent #txtFirstName').val(),
              'last_name': $('#updateStudent #txtLastName').val(),
              'address': $('#updateStudent #txtAddress').val(),
              'id': $('#updateStudent #hdnStudentId').val(),
              "_token": "{{ csrf_token() }}",
          }, function(data){
              console.log(data);
              console.log(id);
              $('#'+id+' td.first_name').html(data.first_name);
              $('#'+id+' td.last_name').html(data.last_name);
              var student_id = $(this).attr('data-id');
              // clear form
              // $('#updateStudent')[0].reset();
              $('#addModal').modal('hide');
          });
	  };



   //  $('body').on('click', '.btnEdit', function () {
   //    var student_id = $(this).attr('data-id');
   //    $.get('student/' + student_id +'/edit', function (data) {
   //        $('#updateModal').modal('show');
   //        $('#updateStudent #hdnStudentId').val(data.id);
   //        $('#updateStudent #txtFirstName').val(data.first_name);
   //        $('#updateStudent #txtLastName').val(data.last_name);
   //        $('#updateStudent #txtAddress').val(data.address);
   //    })
   // });

    // Update the student
	$("#updateStudent").validate({
		 rules: {
				txtFirstName: "required",
				txtLastName: "required",
				txtAddress: "required"
				
			},
			messages: {
			},
 
		 submitHandler: function(form) {
		  var form_action = $("#updateStudent").attr("action");
		  $.ajax({
			  data: $('#updateStudent').serialize(),
			  url: form_action,
			  type: "POST",
			  dataType: 'json',
			  success: function (data) {
				  var student = '<td>' + data.id + '</td>';
				  student += '<td>' + data.first_name + '</td>';
				  student += '<td>' + data.last_name + '</td>';
				  student += '<td>' + data.address + '</td>';
				  student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
				  $('#studentTable tbody #'+ data.id).html(student);
				  $('#updateStudent')[0].reset();
				  $('#updateModal').modal('hide');
			  },
			  error: function (data) {
			  }
		  });
		}
	});		
		
   //delete student
	$('body').on('click', '.btnDelete', function () {
      var student_id = $(this).attr('data-id');
      $.get('student/' + student_id +'/delete', function (data) {
          $('#studentTable tbody #'+ student_id).remove();
      })
   });


	//search

	  $('#btnSearch').click(function () {
          search();
      });

	  $('#txtSearch').keypress(function () {
          search();
      });

	  var search = function() {
          $.post('/student/search/{search}',{
              'txtSearch': $('#txtSearch').val(),
              "_token": "{{ csrf_token() }}",
          }, function (data) {
              console.log(data);
              $("#studentTable tr").remove();
              $.each(data, function(index, student) {
                  // console.log(student);

                  var item = '<tr id="'+student.id+'">';
                  item += '<td>' + student.id + '</td>';
                  item += '<td>' + student.first_name + '</td>';
                  item += '<td>' + student.last_name + '</td>';
                  item += '<td>' + student.address + '</td>';
                  item += '<td><a data-id="' + student.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + student.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
                  item += '</tr>';
                  //
                  console.log(item);
                  //
                  $('#studentTable tbody').prepend(item);
                  // Will stop running after "three"
                  // return (value !== 'three');
              });

          });
      };
	
});	  
</script>
@endsection