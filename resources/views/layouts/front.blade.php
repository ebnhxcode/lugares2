<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Lugares') }}</title>

   <!-- Styles -->
   <!--
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    -->


   <!-- Material Design for Bootstrap fonts and icons -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">

   <link rel="stylesheet" href="{{url('/css/other_libs/bootstrap-material-design.min.css')}}">
   <link rel="stylesheet" href="{{url('/css/other_libs/font-awesome470.min.css')}}">

   <style>
      video {
         position: fixed;
         min-width: 100%;
         min-height: 100%;
         /*top:50px;*/
         z-index: -1;

         /*
         -webkit-filter: grayscale(100%);
         filter: grayscale(100%);
         *//* Safari 6.0 - 9.0 */
         /**/
         -webkit-filter: blur(0px);
         filter: blur(0px);
         /**//* Safari 6.0 - 9.0 */
      }
      body {
         -ms-flex-align: center;
         -ms-flex-pack: center;
         -webkit-box-align: center;
         align-items: center;
         -webkit-box-pack: center;
         justify-content: center;
         background-color: #f5f5f5;
      }
   </style>
</head>
<body>

<!--
<video src="{{url('video/video_back.mp4')}}" autoplay loop></video>
-->

<div id="app">
   <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
         <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Lugares') }}
         </a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
               <!-- Authentication Links -->
               @guest

               @else
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ isset(Auth::user()->nom_usuario) ?
                            Auth::user()->nom_usuario : 'Sin Nombre' }}
                        <span class="caret"></span>
                     </a>
                     <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                           Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                           @csrf
                        </form>
                     </div>
                  </li>
                  @endguest
            </ul>
         </div>
      </div>
   </nav>

   <main class="py-4">

      @yield('content')



   </main>
</div>

@yield('VueControllers')

<script src="{{url('/js/other_libs/bootstrap-material-design.js')}}"></script>
<script src="{{url('/js/other_libs/popper.js')}}"></script>

<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

<!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
</body>
</html>
