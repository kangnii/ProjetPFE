<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Page </title>
    <link rel="apple-touch-icon" href="{{ asset('backend/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/pages/page-auth.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/style.css')}}">
    <!-- END: Custom CSS-->

    {{--jquery--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{--end-jquery--}}

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body" style="transform: scale(1.3)">
            <div class="auth-wrapper auth-v1 px-2">
                <div class="auth-inner py-2">
                    <!-- Login v1 -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="javascript:void(0);" class="brand-logo">
                                <img alt="DIBA IDA Logo" class="w-48 mt-8" src="{{ asset('backend/images/logo/logo_case.png')}}">
                            </a>

                            <h4 class="card-title mb-1">Réinitialiser le mot de passe</h4>
                            @if (session('status'))
                                <p>{{ session('status') }}</p>
                            @endif
                            <p class="card-text mb-2">Réinitialisation du mot de passe </p>

                            @error('message')
                            <div class="alert alert-danger show mb-2" role="alert">{{ $message }}</div>
                            @enderror

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <form id="login-form" class="auth-login-form mt-2" action="{{ route('password.update.reset') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group">
                                    <label for="reset-email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror
" id="reset-email" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" readonly />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                                    @enderror

                                </div>
                                    <label for="reset-password" class="form-label">Nouveau mot de passe</label>
                                <div class="form-group input-group input-group-merge form-password-toggle ">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror
" id="reset-password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required autocomplete="new-password" />
                                    <div class="input-group-append">
                                        <span class="input-group-text cursor-pointer"><i data-feather="eye" style="color: black"></i></span>
                                    </div>
                                </div>


                                <div><label for="reset-password-confirm" class="form-label ">Confimer mot de passe</label></div>
                                <div class="form-group input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control" id="reset-password-confirm" name="password_confirmation"  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required autocomplete="new-password"  />
                                    <div class="input-group-append">
                                        <span class="input-group-text cursor-pointer"><i data-feather="eye" style="color: black"></i></span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block" tabindex="4">Réinitialiser</button>
                            </form>

                        </div>
                    </div>
                    <!-- /Login v1 -->
                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Content-->

{{--jquery--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--end-jquery--}}
<!-- BEGIN: Vendor JS-->
<script src="{{ asset('backend/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('backend/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('backend/js/core/app-menu.js')}}"></script>
<script src="{{ asset('backend/js/core/app.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('backend/js/scripts/pages/page-auth-login.js')}}"></script>
<!-- END: Page JS-->


<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });

    // Gestionnaire d'événements pour afficher ou masquer le mot de passe lorsque l'utilisateur clique sur l'icône
    $(document).on('click', '.toggle-password', function() {
        var passwordInput = $(this).closest('.input-group').find('input[name="password"]');
        var passwordFieldType = passwordInput.attr('type');
        if (passwordFieldType === 'password') {
            passwordInput.attr('type', 'text');
        } else {
            passwordInput.attr('type', 'password');
        }
    });

    $(document).ready(function() {
        $("#reset-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#reset-password"
                }
            },
            messages: {
                email: {
                    required: "Veuillez saisir votre email",
                    email: "Veuillez saisir un email valide"
                },
                password: {
                    required: "Veuillez saisir un mot de passe"
                },
                password_confirmation: {
                    required: "Veuillez confirmer le mot de passe",
                    equalTo: "Les mots de passe ne correspondent pas"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

</script>


</body>


</html>

