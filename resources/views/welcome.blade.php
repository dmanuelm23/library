<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <a href="/">Home</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}">Library</a>
                @else
                    <a href="{{ route('login') }}" >Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" >Register</a>
                    @endif
                @endauth
            @endif
        </nav>
        <section class="text-header">
            <h1>Library</h1>
            <h2>Books and Borrow</h2>
        </section>
        <div class="wave" style="height: 150px; overflow: hidden;">
            <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
                <path d="M0.00,49.98 C150.00,150.00 349.20,-50.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path>
            </svg>
        </div>
    </header>
    <main>
        <section class="container about-us">
            <h2 class="title">Our books</h2>
            <div class="container-about-us">
                <img src="images/ilustracion2.svg" alt="" class="image-about-us">
                <div class="content-text">
                    <h3><span>1</span>The best books</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum magnam pariatur obcaecati nam similique voluptas quia recusandae neque, labore, molestias velit? Voluptates tenetur, consectetur consequatur est aspernatur corrupti pariatur ipsum.</p>
                    <h3><span>2</span>The best books</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum magnam pariatur obcaecati nam similique voluptas quia recusandae neque, labore, molestias velit? Voluptates tenetur, consectetur consequatur est aspernatur corrupti pariatur ipsum.</p>
                </div>                
            </div>
        </section>
        <section class="books">
            <div class="container">
                <h2 class="title">Books</h2>
                    <div class="galery-book">
                        @foreach ($books as $book)
                            <div class="image-book">
                                <img src="images/book.png" alt="">
                                <div class="hover-galery">
                                    <img src="images/icono1.png" alt="">
                                    <p>{{$book->name}}</p>
                                    <p>{{$book->author}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
        </section>
        <section class="customers container">
            <h2 class="title">What our clients say about the books reviews and comments</h2>
            <div class="cards">
                <div class="card">
                    <img src="images/face1.jpg" alt="">
                    <div class="content-text-card">
                        <h4>María José</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, sapiente!</p>
                    </div>
                </div>
                <div class="card">
                    <img src="images/face2.jpg" alt="">
                    <div class="content-text-card">
                        <h4>Luis Manuel</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, sapiente!</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="about-services">
            <div class="container">
                <h2 class="title">Our services</h2>
                <div class="service-cont">
                    <div class="service-ind">
                        <img src="images/ilustracion1.svg" alt="">
                        <h3>Borrow books</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore, qui?</p>
                    </div>
                    <div class="service-ind">
                        <img src="images/ilustracion4.svg" alt="">
                        <h3>Borrow books</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore, qui?</p>
                    </div>
                    <div class="service-ind">
                        <img src="images/ilustracion3.svg" alt="">
                        <h3>Borrow books</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore, qui?</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="container-footer">
            <div class="content-foo">
                <h4>Phone</h4>
                <a href="tel:+529611243648">+529611243648</a>
            </div>
            <div class="content-foo">
                <h4>Email</h4>
                <a href="mailto:luisdaniel_23@hotmail.com">luisdaniel_23@hotmail.com</a>
            </div>
            <div class="content-foo">
                <h4>Location</h4>
                <a href="https://goo.gl/maps/33PbHhsRVzNdmhHr9" target="_blank">Tuxla Gutierrez, Chiapas; México</a>
            </div>
        </div>
        <h2 class="title-final">&copy; {{Carbon\Carbon::now()->format('Y')}} Library | Luis Manuel |  Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</h2>
    </footer>
</body>
</html>