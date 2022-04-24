@extends('companies.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Employee</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('employees.create') }}"> Create New Employee</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered" id="compTable">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone No</th>
            <!-- <th class="noExport">Logo</th> -->
            <th width="280px" class="noExport">Action</th>
        </tr>
        @if(!empty($employees) && $employees->count())
            @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->first_name }}</td>
                <td>{{ $employee->last_name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone }}</td>
                <!-- <td class="noExport"><img src="{{url('/logos/'.$employee->logo)}}" alt="Image" width="200" height="200"/></td> -->
                <td class="noExport">
                    <form action="{{ route('employees.destroy',$employee->id) }}" method="POST" onsubmit="return confirm('Do you really want to delete?');">   
                        <a class="btn btn-info" href="{{ route('employees.show',$employee->id) }}">Show</a>    
                        <a class="btn btn-primary" href="{{ route('employees.edit',$employee->id) }}">Edit</a>   
                        @csrf
                        @method('DELETE')      
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" style="text-align:center">There are no data.</td>
            </tr>
        @endif
    </table>
  
    {!! $employees->appends(['sort' => 'votes'])->links() !!}
      
@endsection
