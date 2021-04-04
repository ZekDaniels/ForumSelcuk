@include('layouts.header')
<!-- Main Content -->
<div class="content">
    <div class="container-fluid">
        @include('partials.alert')
        @yield('content')
        @stack('scripts')
    </div>
</div>
<!-- /.content -->
@include('layouts.footer')
