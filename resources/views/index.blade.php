@include('admin.layouts.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

       @include('admin.layouts.navbar')

        <!-- Main Sidebar Container -->
       @include('admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
        @yield('content')
        </div>
       @include('admin.layouts.footer')


</body>

</html>
