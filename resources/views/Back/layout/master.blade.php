<!DOCTYPE html>
<html lang="en">

@include('Back.layout._head')

<body>
    @include('sweetalert::alert')
    <div id="app">

        @include('Back.layout._sidebar')
        <div id="main">


            @include('Back.layout._header')


            <div class="page-content">
                @yield('konten-admin')

            </div>
            @include('Back.layout._footer')

        </div>
    </div>
    @include('Back.layout._script')
    @yield('script')
</body>

</html>
