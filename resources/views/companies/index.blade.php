@extends('companies.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Company</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('companies.create') }}"> Create New Company</a>
                <a class="btn btn-success" href="{{ route('import-company') }}"> Import</a>
                <button id="exportToExcel" class="btn btn-success"> Export</button>
            </div>
        </div>
    </div>
    <div>
        <a href="{{ URL::to('/') }}/sample_csv.csv"> Sample CSV file to import</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered" id="compTable">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Website</th>
            <!-- <th class="noExport">Logo</th> -->
            <th width="280px" class="noExport">Action</th>
        </tr>
        @if(!empty($companies) && $companies->count())
            @foreach ($companies as $company)
            <tr>
                <td>{{ $company->name }}</td>
                <td>{{ $company->email }}</td>
                <td>{{ $company->website }}</td>
                <!-- <td class="noExport"><img src="{{url('/logos/'.$company->logo)}}" alt="Image" width="200" height="200"/></td> -->
                <td class="noExport">
                    <form action="{{ route('companies.destroy',$company->id) }}" method="POST" onsubmit="return confirm('Do you really want to delete?');">   
                        <a class="btn btn-info" href="{{ route('companies.show',$company->id) }}">Show</a>    
                        <a class="btn btn-primary" href="{{ route('companies.edit',$company->id) }}">Edit</a>   
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
  
    {!! $companies->appends(['sort' => 'votes'])->links() !!}
      
@endsection


<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script>
    $(document).ready(function () {
        $("#exportToExcel").click(function(){
            $("#compTable").table2excel({
                filename: "Companies.xls",
                exclude: ".noExport"
            });
        });
    });
</script>