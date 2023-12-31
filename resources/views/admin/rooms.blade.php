@extends('admin.layouts.admin')

@section('title', 'Room Management')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Room Management</h1>
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
                    <!-- Add Room Form -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Room</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="roomName">Room Name</label>
                                    <input type="text" class="form-control" id="roomName" name="roomName" placeholder="Enter room name" required>
                                </div>
                                <div class="form-group">
                                    <label for="ownerName">Owner Name</label>
                                    <input type="text" class="form-control" id="ownerName" name="ownerName" placeholder="Enter owner name" required>
                                </div>
                                <div class="form-group">
                                    <label for="ownerSkills">Owner Skills</label>
                                    <input type="text" class="form-control" id="ownerSkills" name="ownerSkills" placeholder="Enter owner skills" required>
                                </div>
                                <div class="form-group">
                                    <label for="seekingSkills">Seeking Skills</label>
                                    <input type="text" class="form-control" id="seekingSkills" name="seekingSkills" placeholder="Enter seeking skills" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Room</button>
                            </form>
                        </div>
                    </div>
                </div>

                
            </div>

            <div class="col-md-12">
                <!-- Rooms table -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List of Rooms</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Room Name</th>
                                    <th>Owner Name</th>
                                    <th>Owner Skills</th>
                                    <th>Seeking Skills</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through rooms and display them -->
                                @php
                                    $rooms = [
                                        ['id' => 1, 'roomName' => 'Web Development Group', 'ownerName' => 'John Doe', 'ownerSkills' => 'Web Development', 'seekingSkills' => 'Graphic Design'],
                                        ['id' => 2, 'roomName' => 'Design Enthusiasts', 'ownerName' => 'Jane Doe', 'ownerSkills' => 'Graphic Design', 'seekingSkills' => 'Web Development'],
                                        // Add more dummy rooms as needed
                                    ];
                                @endphp
                                @foreach($rooms as $room)
                                    <tr>
                                        <td>{{ $room['id'] }}</td>
                                        <td>{{ $room['roomName'] }}</td>
                                        <td>{{ $room['ownerName'] }}</td>
                                        <td>{{ $room['ownerSkills'] }}</td>
                                        <td>{{ $room['seekingSkills'] }}</td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editRoomModal{{ $room['id'] }}">Edit</a>
                                            <form action="#" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Edit Room Modal -->
                                    <!-- Edit Room Modal -->
                                    <div class="modal fade" id="editRoomModal{{ $room['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editRoomModal{{ $room['id'] }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editRoomModal{{ $room['id'] }}Label">Edit Room</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="#" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <!-- Add fields for room edit form -->
                                                        <!-- Example: -->
                                                        <div class="form-group">
                                                            <label for="editRoomName{{ $room['id'] }}">Room Name</label>
                                                            <input type="text" class="form-control" id="editRoomName{{ $room['id'] }}" name="editRoomName" value="{{ $room['roomName'] }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editOwnerName{{ $room['id'] }}">Owner Name</label>
                                                            <input type="text" class="form-control" id="editOwnerName{{ $room['id'] }}" name="editOwnerName" value="{{ $room['ownerName'] }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editOwnerSkills{{ $room['id'] }}">Owner Skills</label>
                                                            <input type="text" class="form-control" id="editOwnerSkills{{ $room['id'] }}" name="editOwnerSkills" value="{{ $room['ownerSkills'] }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editSeekingSkills{{ $room['id'] }}">Seeking Skills</label>
                                                            <input type="text" class="form-control" id="editSeekingSkills{{ $room['id'] }}" name="editSeekingSkills" value="{{ $room['seekingSkills'] }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Update Room</button>
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
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
