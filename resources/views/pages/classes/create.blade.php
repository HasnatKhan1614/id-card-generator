@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Class</h3>
            </div>
            <div class="card-body">
                <form id="form" action="{{ route('classes.store') }}" method="POST" data-method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="name">Class name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Grade 1" required>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="sort_order">Sort order</label>
                            <input type="number" id="sort_order" name="sort_order" class="form-control" value="0" min="0">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="is_active">Status</label>
                            <select id="is_active" name="is_active" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('classes.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
