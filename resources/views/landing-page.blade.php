<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('fr/assets/libs/OwlCarousel-2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fr/dist/css/iconfont/tabler-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('fr/dist/css/style.css') }}">
</head>

<body>
    <!------------------------------>
    <!-- Header Start -->
    <!------------------------------>
    <header class="main-header position-fixed w-100">
        <div class="container">
            <nav class="navbar navbar-expand-xl py-0">
                <div class="logo">
                    <a class="navbar-brand py-0 me-0" href="#"><strong>{{ config('app.name') }}</strong></a>
                </div>
                <a class="d-inline-block d-lg-block d-xl-none d-xxl-none  nav-toggler text-decoration-none"
                    data-bs-toggle="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample">
                    <i class="ti ti-menu-2 text-warning"></i>
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        {{-- <li class="nav-item">
                            <a class="nav-link text-capitalize" aria-current="page" href="#">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" href="#">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" href="#">Pricing </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" href="#">Elements </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" href="#">blog</a>
                        </li> --}}
                    </ul>
                    <div class="d-flex align-items-center">

                        <a class="btn btn-warning btn-hover-secondery text-capitalize "
                            href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </nav>
        </div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <a class="navbar-brand py-0 me-0" href="#"><img src="../assets/images/Creato-logo.svg"
                            alt=""></a>
                </div>
                <button type="button" class="btn-close text-reset  ms-auto" data-bs-dismiss="offcanvas"
                    aria-label="Close"><i class="ti ti-x text-warning"></i></button>
            </div>
            <div class="offcanvas-body pt-0">
                <ul class="navbar-nav">
                    {{-- <li class="nav-item">
                        <a class="nav-link text-capitalize" aria-current="page" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" href="#">Pricing </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" href="#">Elements </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" href="#">blog </a>
                    </li> --}}
                </ul>
                <div class="login d-block align-items-center mt-3">
                    <a class="btn btn-warning btn-hover-secondery text-capitalize "
                        href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </header>
    <!------------------------------>
    <!-- Header End  -->
    <!------------------------------>

    <!------------------------------>
    <!--- Hero Banner Start--------->
    <!------------------------------>
    <section class="hero-banner position-relative overflow-hidden">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="position-relative left-hero-color">
                        <h1 class="mb-0 fw-bold">
                            Digitalisasikan pengelolaan keuangan masjid/mushola
                        </h1>
                        <h4 class="mt-1">Bersama Al-Lail.com</h4>

                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="position-relative right-hero-color">
                        <img src="{{ asset('fr/assets/images/hero/right-image.svg') }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------------------>
    <!--- Hero Banner End--------->
    <!------------------------------>

    <!------------------------------>
    <!--- Service sectin Start------>
    <!------------------------------>
    <section class="service position-relative overflow-hidden">
        <div class="container position-relative">
            <img src="{{ asset('fr/assets/images/service/dot-shape.png') }}" class="shape position-absolute">
            <div class="row">

                <div
                    class="col-12 d-xxl-flex d-xl-flex d-lg-flex d-md-flex d-sm-block d-block align-items-center justify-content-xxl-between justify-content-xl-between justify-content-lg-between justify-content-md-between justify-content-sm-between justify-content-sm-center ">
                    <h2 class="fs-2 text-black mb-0">Langkah mudah menggunakan<br> Al-Lail.com</h2>

                </div>
            </div>
            <div class="row d-flex flex-wrap justify-content-center step-row">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 text-center">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div
                                class="icon-round overflow-hidden rounded-circle position-relative d-flex align-items-center justify-content-center mx-auto text-center">
                                <i class="ti ti-download text-primary position-relative"></i>
                            </div>
                            <h5 class="mb-0 fw-500">Step 1</h5>
                            <h3 class="fs-4">Akses Aplikasi</h3>
                            <p class="fs-7 mb-0 fw-500">Kunjungi alamat webiste kami www.al-lail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 text-center">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div
                                class="icon-round overflow-hidden rounded-circle position-relative d-flex align-items-center justify-content-center mx-auto text-center">
                                <i class="ti ti-user text-primary position-relative"></i>
                            </div>
                            <h5 class="mb-0 fw-500">Step 2</h5>
                            <h3 class="fs-4">Buat akun</h3>
                            <p class="fs-7 mb-0 fw-500">Buat akun dan isi formulir yang diminta</p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 text-center">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div
                                class="icon-round overflow-hidden rounded-circle position-relative d-flex align-items-center justify-content-center mx-auto text-center">
                                <i class="ti ti-gift text-primary position-relative"></i>
                            </div>
                            <h5 class="mb-0 fw-500">Step 3</h5>
                            <h3 class="fs-4">Explore semua fitur</h3>
                            <p class="fs-7 mb-0 fw-500">Untuk informasi lebih lengkap silahkan kunjungi panduan aplikasi
                                kami</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------------------>
    <!--- Service sectin Start------>
    <!------------------------------>

    <!------------------------------>
    <!-- Pricing section Start------>
    <!------------------------------>
    <section class="pricing position-relative overflow-hidden">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                    <small class="fs-7 d-block"></small>
                    <h2 class="fs-3 pricing-head text-black mb-0 position-relative">Apa kata pemilik</h2>
                </div>
            </div>
            <div class="row mt-5 text-center">
                <figure>
                    <blockquote class="blockquote">
                        <p>Aplikasi ini saya rancang untuk membantu umat Islam dalam mengelola keuangan masjid dan
                            kemudahan transparansi data bagi umat.
                            Akses gratis selamanya, salam kenal dari saya, saya hanya meminta cukup doakan saya dengan
                            doa yang baik, dan silahkan gunakan aplikasi ini.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer mt-3">
                        Founder of Nusantara Technology Indonesia <cite title="Source Title">Dicky Hermawan</cite>
                    </figcaption>
                </figure>
            </div>

        </div>
    </section>
    <!------------------------------>
    <!-- Pricing section End-------->
    <!------------------------------>

    <!------------------------------>
    <!------ FAQ section Start------>
    <!------------------------------>
    {{-- <section class="faq position-relative overflow-hidden">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <small class="fs-7 d-block">Frequently Asked Questions</small>
                    <h2 class="fs-3 text-black mb-0">Want to ask something from us?</h2>
                </div>
            </div>
            <div class="accordion-block">
                <div class="accordion row" id="accordionPanelsStayOpenExample">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne"
                                    aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Letraset sheets containing sum passages ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    There are many variations ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                    Lorem Ipsum generators on the Internet tend ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingfour">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefour"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapsefour">
                                    Various versions have evolved over the ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapsefour" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingfour">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingfive">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefive"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapsefive">
                                    Finibus bonorum et malorum ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapsefive" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingfour">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingsix">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsesix"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapsesix">
                                    Many desktop publishing packages ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapsesix" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingsix">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!------------------------------>
    <!------ FAQ section End------>
    <!------------------------------>

    <!------------------------------>
    <!-----Contact section Start---->
    <!------------------------------>
    <section class="contact bg-primary position-relative overflow-hidden">
        <div class="container position-relative">

            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h5 class="fs-7 d-block text-warning">Join us Now</h5>
                    <h2 class="fs-3 text-white mb-0">Siap untuk mencoba produk ini secara gratis?</h2>
                    <div class="owl-carousel owl-theme testimonial">
                        <div class="item">
                            <div class="details position-relative">
                                <p class="fs-5 fw-light blue-light mb-4">
                                    Dengan Al-Lail.com, kita tidak perlu lagi repot dalam hal laporan bulanan, cukup
                                    sekali klik semua proses terdigitalisasi
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="avtar-img rounded-circle overflow-hidden"><img
                                            src="{{ asset('fr/assets/images/contact/testimonial-image.png') }}"
                                            class="img-fluid">
                                    </div>
                                    <div class="name ps-3">
                                        <h6 class="text-white">Merky Lester</h6>
                                        <small class="d-block blue-light fw-500 fs-10 pb-0">Bendahara DKM</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="details position-relative">
                                <p class="fs-5 fw-light blue-light mb-4">
                                    Al-Lail.com sangat membantu masjid kami dalam hal keterbukaan informasi terkait kas
                                    yang kami kelola
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="avtar-img rounded-circle overflow-hidden"><img
                                            src="{{ asset('fr/assets/images/contact/testimonial-image.png') }}"
                                            class="img-fluid">
                                    </div>
                                    <div class="name ps-3">
                                        <h6 class="text-white">Ahmad aldi</h6>
                                        <small class="d-block blue-light fw-500 fs-10 pb-0">Ketua DKM</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('register_membership') }}"
                            class="btn btn-warning btn-hover-secondery text-capitalize mt-2 w-auto contact-btn">
                            Daftar gratis</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!------------------------------>
    <!-----Contact section End----->
    <!------------------------------>

    <!------------------------------>
    <!-----Footer Start------------->
    <!------------------------------>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-logo-col">
                        <a href="#"
                            class="text-white text-decoration-none h3"><strong>{{ config('app.name') }}</strong></a>
                        <p class="blue-light mb-0 fs-7 fw-500">Digitalisasikan pengelolaan keuangan masjid atau
                            musholamu.<br>
                            Al-Lail.com product of Nusantara Technology Indonesia
                            under trade mark of networkdelivr.my.id</p>
                        <div class="callus text-white fw-500 fs-7">
                            <div class="blue-light">Email us: <a href="#"
                                    class="text-warning fw-500 fs-7 text-decoration-none">customer.service@networkdelivr.my.id</a>
                                <a href="#"
                                    class="text-warning fw-500 fs-7 text-decoration-none">info@al-lail.com</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-12">

                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-12">
                    <h5 class="text-white">Company</h5>
                    <ul class="list-unstyled mb-0 pl-0">
                        <li><a href="#">Term & Condition</a></li>
                        <li><a href="#">Legal & Privacy</a></li>
                    </ul>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="subscribe">
                        <h5 class="text-white">Become a members</h5>

                        <div class="input-group">
                            <a href="{{ route('register_membership') }}"
                                class="btn btn-warning btn-hover-secondery ms-xxl-2 ms-xl-2 ls-lg-0 ms-md-0 ms-sm-0 ms-0"
                                type="button" id="button-addon2">Register</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyrights text-center blue-light  fw-500">@<span id="autodate">2023</span> - All Rights
                Reserved,
            </div>
        </div>
    </footer>
    <!------------------------------>
    <!-------Footer End------------->
    <!------------------------------>


    <script src="{{ asset('fr/dist/js/jquery.min.js') }}"></script>
    <script src="{{ asset('fr/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('fr/assets/libs/OwlCarousel-2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('fr/dist/js/custom.js') }}"></script>

</body>

</html>
