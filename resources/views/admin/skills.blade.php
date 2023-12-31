@extends('admin.layouts.admin')

@section('title', 'Skill Management')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Skill Management</h1>
                </div>
                <div class="col-sm-6">
                    <!-- Add your breadcrumb or additional information here -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Add your content here -->
            <div class="row">
                <div class="col-md-6">
                    <!-- Add Skill Form -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Skill</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="skillName">Skill Name</label>
                                    <input type="text" class="form-control" id="skillName" name="skillName" placeholder="Enter skill name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Skill</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Skills table -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Skills</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Skill Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Loop through skills and display them -->
                                    @php
                                        $skills = [
                                            ['id' => 1, 'skillName' => 'Web Development'],
                                            ['id' => 2, 'skillName' => 'Graphic Design'],
                                            // Add more dummy skills as needed
                                        ];
                                    @endphp
                                    @foreach($skills as $skill)
                                        <tr>
                                            <td>{{ $skill['id'] }}</td>
                                            <td>{{ $skill['skillName'] }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editSkillModal{{ $skill['id'] }}">Edit</a>
                                                <form action="#" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <!-- Edit Skill Modal -->
                                        <!-- Edit Skill Modal -->
                                        <div class="modal fade" id="editSkillModal{{ $skill['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editSkillModal{{ $skill['id'] }}Label" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSkillModal{{ $skill['id'] }}Label">Edit Skill</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="#" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="editSkillName{{ $skill['id'] }}">Skill Name</label>
                                                                <input type="text" class="form-control" id="editSkillName{{ $skill['id'] }}" name="editSkillName" value="{{ $skill['skillName'] }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Update Skill</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
