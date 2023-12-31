@extends('admin.layouts.admin')

@section('title', 'Booking Management')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Booking Management</h1>
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
                    <!-- Add Booking Form -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Booking</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="roomName">Room Name</label>
                                    <input type="text" class="form-control" id="roomName" name="roomName" placeholder="Enter room name" required>
                                </div>
                                <div class="form-group">
                                    <label for="participantName">Participant Name</label>
                                    <input type="text" class="form-control" id="participantName" name="participantName" placeholder="Enter participant name" required>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                                <div class="form-group">
                                    <label for="time">Time</label>
                                    <input type="time" class="form-control" id="time" name="time" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Book Room</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Bookings table -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Bookings</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Room Name</th>
                                        <th>Participant Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Loop through bookings and display them -->
                                    @php
                                        $bookings = [
                                            ['id' => 1, 'roomName' => 'Web Development Group', 'participantName' => 'Alice Smith', 'date' => '2023-01-15', 'time' => '10:00 AM'],
                                            ['id' => 2, 'roomName' => 'Design Enthusiasts', 'participantName' => 'Bob Johnson', 'date' => '2023-01-20', 'time' => '02:30 PM'],
                                            // Add more dummy bookings as needed
                                        ];
                                    @endphp
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>{{ $booking['id'] }}</td>
                                            <td>{{ $booking['roomName'] }}</td>
                                            <td>{{ $booking['participantName'] }}</td>
                                            <td>{{ $booking['date'] }}</td>
                                            <td>{{ $booking['time'] }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editBookingModal{{ $booking['id'] }}">Edit</a>
                                                <form action="#" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <!-- Edit Booking Modal -->
                                        <!-- Edit Booking Modal -->
                                        <div class="modal fade" id="editBookingModal{{ $booking['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editBookingModal{{ $booking['id'] }}Label" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editBookingModal{{ $booking['id'] }}Label">Edit Booking</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="#" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <!-- Add fields for booking edit form -->
                                                            <div class="form-group">
                                                                <label for="editBookingRoom{{ $booking['id'] }}">Booking Room</label>
                                                                <input type="text" class="form-control" id="editBookingRoom{{ $booking['id'] }}" name="editBookingRoom" value="{{ $booking['roomName'] }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editBookingParticipant{{ $booking['id'] }}">Booking Participant</label>
                                                                <input type="text" class="form-control" id="editBookingParticipant{{ $booking['id'] }}" name="editBookingParticipant" value="{{ $booking['participantName'] }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editBookingdate{{ $booking['id'] }}">Booking Date</label>
                                                                <input type="date" class="form-control" id="editBookingDate{{ $booking['id'] }}" name="editBookingDate" value="{{ $booking['date'] }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editBookingTime{{ $booking['id'] }}">Booking Time</label>
                                                                <input type="time" class="form-control" id="editBookingTime{{ $booking['id'] }}" name="editBookingTime" value="{{ $booking['time'] }}" required>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary">Update Booking</button>
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
