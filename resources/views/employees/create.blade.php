@extends('companies.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Employee</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('companies.index') }}"> Back</a>
        </div>
    </div>
</div>
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('employees.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Company<span style="color:red">*</span>:</strong>
                <select class="form-select" name="company_id">
                    <option value="">Select Company</option>
                    @if(!empty($companies) && $companies->count())
                        @foreach ($companies as $companies)
                            <option value="{{ $companies->id }}">{{ $companies->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>First Name<span style="color:red">*</span>:</strong>
                <input type="text" name="first_name" class="form-control" placeholder="First Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Last Name<span style="color:red">*</span>:</strong>
                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email<span style="color:red">*</span>:</strong>
                <input type="text" name="email" class="form-control" placeholder="Email">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Phone<span style="color:red">*</span>:</strong>
                <input type="text" name="phone" class="form-control" placeholder="Phone">
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
@endsection