<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Painel</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

</head>
<body>
    <div class="menu">
        <ul class="menu col-md-12">
            <li class="col-md-2 text-center">
                <a href="/painel/posts">
                    <img src="{{url('/assets/painel/imgs/posts.png')}}" alt="posts" class="img-circle"> 
                </a>                
            </li>
            <li class="col-md-2 text-center">
                <a href="/portal">
                    <img src="{{url('/assets/painel/imgs/portal.png')}}" alt="portal" class="img-circle"> 
                </a>                
            </li>
            <li class="col-md-2 text-center">
                <a href="campus">
                    <img src="{{url('/assets/painel/imgs/campus.png')}}" alt="campus" class="img-circle"> 
                </a>                
            </li>
        </ul>        

        @yield('content')
    </div>

</body>
</html>
