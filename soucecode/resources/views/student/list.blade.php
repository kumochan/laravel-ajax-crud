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