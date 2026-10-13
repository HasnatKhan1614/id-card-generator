@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Student Edit</h3>
                    </div>
                    <div class="card-body">
                        <form id="form" action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Spoofing the PUT method as Laravel requires -->
                            <div class="row">


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sid">Student ID (SID)</label>
                                        <input type="text" id="sid" name="sid" value="{{ $student->sid }}" class="form-control" placeholder="Enter Student ID" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="campus">Campus</label>
                                        <select class="select2bs4 form-control" id="campus" name="campus"
                                            data-placeholder="Select Campus" style="width: 100%;" required>
                                            <x-campus-options :selected="$student->campus" />
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="class">Class</label>
                                        <select class="select2bs4 form-control" id="class" name="class"
                                            data-placeholder="Select Class" style="width: 100%;" required>
                                            <x-class-options :selected="$student->class" />
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" id="first_name" name="first_name" value="{{ $student->first_name }}" class="form-control" placeholder="Enter First Name" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" value="{{ $student->last_name }}" class="form-control" placeholder="Enter Last Name">
                                    </div>
                                </div>

                                                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="student_name">Student Name (as it will appear on card)</label>
                                            <input type="text" id="student_name" name="student_name" value="{{ $student->student_name }}" class="form-control"
                                                placeholder="Student Name">

                                        </div>
                                    </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="father_name">Guardian Name</label>
                                        <input type="text" id="father_name" name="father_name" value="{{ $student->father_name }}" class="form-control" placeholder="Enter Guardian Name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" id="phone" name="phone" value="{{ $student->phone }}" class="form-control" placeholder="Enter Phone Number">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" id="dob" name="dob" value="{{ $student->dob }}" class="form-control" placeholder="Enter Date of Birth">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" id="address" name="address" value="{{ $student->address }}" class="form-control" placeholder="Enter Address">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="is_registered">Allow Registrations</label>
                                        <select id="is_registered" name="is_registered" class="form-control">
                                            <option value="1" {{ $student->is_registered == 0 ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ $student->is_registered == 1 ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="image">Upload Image</label>
                                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*">

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection