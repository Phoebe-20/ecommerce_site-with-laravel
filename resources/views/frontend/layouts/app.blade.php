<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ !empty($meta_title) ? $meta_title : '' }}</title>

    @if(!empty($meta_description ))
    <meta name="description" content="{{ $meta_description }}">
    @endif

    @if(!empty($meta_keywords))
    <meta name="keywords" content="{{ $meta_keywords }}">
    @endif
    
    <link rel="shortcut icon" href="{{ url('assets/images/icons/favicon.ico') }}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Fichier Main CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">

    @yield('style')

</head>

<body>
    <div class="page-wrapper">

        @include('frontend.layouts._header')

        @yield('content')

        @include('frontend.layouts._footer')

    </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>

    @include('frontend.layouts._mobile_menu')
    
    <!-- Page de connection et d'inscription -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Se connecter</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">S'inscrire</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="" id="SubmitFormLogin" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="signin-email">Adresse Mail  *</label>
                                            <input type="email" class="form-control" id="signin-email" name="email" autocomplete="email" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="signin-password">Mot de passe *</label>
                                            <input type="password" class="form-control" id="signin-password" name="password" autocomplete="new-password" required>
                                        </div>

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>S'inscrire</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="is_remember" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Se rappeler de moi</label>
                                            </div>

                                            <a href="{{ url('forgot-password') }}" class="forgot-link">Mot de passe oublié ?</a>
                                        </div>
                                    </form>
                                </div>   

                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form action="" id="SubmitFormRegister" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="register-name">Nom *</label>
                                            <input type="text" class="form-control" id="register-name" name="name" autocomplete="name" required>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="register-email">Adresse mail *</label>
                                            <input type="email" class="form-control" id="register-email" name="email" autocomplete="email" required>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="register-password">Mot de passe *</label>
                                            <input type="password" class="form-control" id="register-password" name="password" autocomplete="new-password" required>
                                        </div>
                                    
                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>Se connecter</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                    
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy" style="font-size: 12px;">
                                                    J'accepte la <a href="#">Politique de confidentialité</a> *
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- La newsletter -->
    {{--<div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="{{ url('assets/images/popup/newsletter/logo.png') }}" class="logo" alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Abonnez-vous à la newsletter de Molla pour reçevoir des mises à jours opportunes sur vos produits préférés.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div>
                                </div>
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Ne plus afficher cette fenêtre</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="{{ url('assets/images/popup/newsletter/img-1.jpg') }}" class="newsletter-img" alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div>--}}


    <!-- Plugins JS File -->
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/js/superfish.min.js') }}"></script>
    <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
    @yield('script')
    <!-- Main JS File -->
    <script src="{{ url('assets/js/main.js') }}"></script>


    <script type="text/javascript">

        
        $('body').delegate('#SubmitFormLogin', 'submit', function(e) 
        {
            e.preventDefault();
            $.ajax({
                type : "POST",
                url : "{{ url('auth_login') }}",
                data : $(this).serialize(),
                dataType : "json",
                success: function (data) 
                {                   
                   if (data.status == true) 
                   {
                        location.reload();
                   }
                   else
                   {
                        alert(data.message);
                   }
                },
                error: function (data) {
                    
                }
            });

            
        });



        $('body').delegate('#SubmitFormRegister', 'submit', function(e) 
        {
            e.preventDefault();
            $.ajax({
                type : "POST",
                url : "{{ url('auth_register') }}",
                data : $(this).serialize(),
                dataType : "json",
                success: function (data) 
                {
                   alert(data.message);
                   
                   if (data.status == true) 
                   {
                        location.reload();
                   }
                },
                error: function (data) {
                    
                }
            });

            
        });

    </script>

</body>

</html>
