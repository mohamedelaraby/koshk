@include('layouts.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

       @include('layouts.navbar')

        <!-- Main Sidebar Container -->
       @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
        @yield('content')
        </div>
       @include('layouts.footer')

   
</body>

</html>