@extends('admin.layouts.admin')

@section('title', 'User Management')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">User Management</h1>
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
                    <!-- Add User Form -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add User</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="#" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address" required>
                                </div>
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter your first name" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter your last name" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" pattern="[0-9]{10}" class="form-control" placeholder="1234567890" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Choose a username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                                </div>
                                <div class="form-group">
                                    <label for="skills">Skills (comma-separated)</label>
                                    <input type="text" name="skills" id="skills" class="form-control" placeholder="e.g., Web Development, Graphic Design" required>
                                </div>
                                <div class="form-group">
                                    <label for="bio">Bio</label>
                                    <textarea name="bio" id="bio" class="form-control" placeholder="Tell us about yourself" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="profilePicture">Profile Picture</label>
                                    <input type="file" name="profilePicture" id="profilePicture" class="form-control" placeholder="Upload your profile picture" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

                           <div class="col-md-12">
                    <!-- Users table -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Users</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Loop through users and display them -->
                                    @php
                                        $users = [
                                            ['id' => 1, 'email' => 'john@example.com', 'first_name' => 'John', 'last_name' => 'Doe', 'phone' => '1234567890', 'username' => 'john_doe', 'skills' => 'Web Development, Graphic Design', 'bio' => 'A passionate developer', 'profilePicture' => 'user1.jpg'],
                                            ['id' => 2, 'email' => 'jane@example.com', 'first_name' => 'Jane', 'last_name' => 'Doe', 'phone' => '9876543210', 'username' => 'jane_doe', 'skills' => 'UI/UX Design, Mobile App Development', 'bio' => 'Creative designer', 'profilePicture' => 'user2.jpg'],
                                            // Add more dummy users as needed
                                        ];
                                    @endphp
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user['id'] }}</td>
                                            <td>{{ $user['email'] }}</td>
                                            <td>{{ $user['first_name'] }}</td>
                                            <td>{{ $user['last_name'] }}</td>
                                            <td>{{ $user['phone'] }}</td>
                                            <td>{{ $user['username'] }}</td>
                                            <td>{{ $user['skills'] }}</td>
                                            <td>{{ $user['bio'] }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editUserModal{{ $user['id'] }}">Edit</a>
                                                <form action="#" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <!-- Edit User Modal -->
                                        <div class="modal fade" id="editUserModal{{ $user['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editUserModal{{ $user['id'] }}Label" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUserModal{{ $user['id'] }}Label">Edit User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="#" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="edit_email">Email Address</label>
                                                                <input type="email" name="edit_email" id="edit_email" class="form-control" placeholder="Enter your email address" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_first_name">First Name</label>
                                                                <input type="text" name="edit_first_name" id="edit_first_name" class="form-control" placeholder="Enter your first name" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_last_name">Last Name</label>
                                                                <input type="text" name="edit_last_name" id="edit_last_name" class="form-control" placeholder="Enter your last name" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_phone">Phone Number</label>
                                                                <input type="tel" name="edit_phone" id="edit_phone" pattern="[0-9]{10}" class="form-control" placeholder="1234567890" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_username">Username</label>
                                                                <input type="text" name="edit_username" id="edit_username" class="form-control" placeholder="Choose a username" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_password">Password</label>
                                                                <input type="password" name="edit_password" id="edit_password" class="form-control" placeholder="Enter your password" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_skills">Skills (comma-separated)</label>
                                                                <input type="text" name="edit_skills" id="edit_skills" class="form-control" placeholder="e.g., Web Development, Graphic Design" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_bio">Bio</label>
                                                                <textarea name="edit_bio" id="edit_bio" class="form-control" placeholder="Tell us about yourself" required></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_profilePicture">Profile Picture</label>
                                                                <input type="file" name="edit_profilePicture" id="edit_profilePicture" class="form-control" placeholder="Upload your profile picture" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
