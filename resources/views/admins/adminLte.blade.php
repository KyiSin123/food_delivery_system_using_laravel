<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>

    <!-- Font Awesome -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" />    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/css/adminlte.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/example-styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/image-uploader.css') }}">

    <style>
        .logout-btn {
            color: #c2c7d0;
        }

        .logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
    </style>
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>                
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <h4 class="brand-text font-weight-light">Delicious Food</h4>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('/img/user-icon.png')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->guard('admin')->user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('admins.dashboard') }}" class="nav-link active">
                                <i class="nav-icon fa-sharp fa-solid fa-gauge-high"></i>
                                <p>
                                    {{ __('Dashboard') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admins.users.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>
                                    {{ __('Users') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admins.shops.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-store"></i> 
                                <p>
                                     {{ __('Shops') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admins.adminUsers.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    {{ __('Admin Users') }}
                                </p>                                
                            </a>                            
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admins.menuTypes.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-utensils"></i>
                                <p>
                                    {{ __('Menu Types') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admins.receipts.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-invoice-dollar"></i>
                                <p>
                                    {{ __('Receipts') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <form action="{{ route('admins.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn logout-btn ps-3">
                                    <i class="nav-icon fa-solid fa-right-from-bracket"></i>                               
                                        {{ __('Logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
      
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <!-- right col -->
                @yield('content')
                <!-- /.row (main row) -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
      </div>
    <!-- ./wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/js/adminlte.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript">
    $(function(){
        $('#categories').multiSelect();
    });
	function previewImage(event) {
		var ofReader = new FileReader();
		ofReader.readAsDataURL(document.getElementById("fileInput").files[0]);
		ofReader.onload = function(oFREvent) {
			document.getElementById("uploadImage").src = oFREvent.target.result;
		};
	};
    var url = "";

    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });
    
    </script>
</body>

</html>