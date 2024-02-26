<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">{{Auth::user()->name}}</h5>

                <div>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="index.html" class="nav-link active">
                        <i class="ph-house"></i>
                        <span>Dashboard<span class="d-block fw-normal opacity-50">No pending orders</span></span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{route('crud-generator')}}" class="nav-link">
                        <i class="fa fa-location-arrow"></i>
                        <span>CRUD GENERATOR</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('city.index')}}" class="nav-link">
                        <i class="fa fa-location-arrow"></i>
                        <span>City</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('uploaded-files.index')}}" class="nav-link">
                        <i class="fa fa-file"></i>
                        <span>Uploaded File</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.index')}}" class="nav-link">
                        <i class="fa fa-user"></i>
                        <span>User Management</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('role.index')}}" class="nav-link">
                        <i class="fa fa-user"></i>
                        <span>Role && Permission</span>
                    </a>
                </li>






            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
