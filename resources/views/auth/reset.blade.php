@extends('frontend.layouts.app')

@section('style')
@endsection

@section('content')

    <main class="main">

        <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('{{ url('assets/images/backgrounds/login-bg.jpg') }}')">
            <div class="container">
                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="false">Réinitialisation</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="" style="display: block;">
                                @include('frontend.layouts._message')
                                <form action="" id="" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group" style="margin-top: 40px;">
                                        <label for="singin-password">Nouveau mot de passe  *</label>
                                        <input type="password" class="form-control" id="singin-password" name="password" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="singin-password">Confirmez le mot de passe  *</label>
                                        <input type="password" class="form-control" id="singin-password" name="cpassword" required>
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>Réinitialiser</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
@endsection