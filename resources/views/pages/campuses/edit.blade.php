@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Campus</h3>
            </div>
            <div class="card-body">
                <form id="form" action="{{ route('campuses.update', $campus->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $campus->name }}" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $campus->email }}" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="contact_number">Phone</label>
                            <input type="text" id="contact_number" name="contact_number" class="form-control" value="{{ $campus->contact_number }}" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" class="form-control" value="{{ $campus->address }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('campuses.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
