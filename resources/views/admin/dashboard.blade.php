@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Add your content and statistics cards here -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53</h3>
                        <p>Rooms</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-home"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Bookings</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-calendar"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Skiils</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-book"></i>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <!-- Placeholder for additional content -->
        <div class="card">
            <div class="card-body">
</div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
@endsection
