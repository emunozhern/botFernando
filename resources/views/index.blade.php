<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bot::Fernando</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            background: url(./bg.png);
        }
    </style>
</head>

<body>
    <div class="container">

        <img src="{{ asset('logo.png') }}" alt="">

        <div class="row">
            <div class="col-12 mb-2">
                <button type="submit" id="voteBlog" class="btn btn-danger">
                    Votar Blogs
                    <i class='d-none load fa fa-spinner fa-spin'></i>
                </button>
                <button type="submit" id="voteProfile" class="btn btn-danger">
                    Votar Perfiles
                    <i class='d-none load fa fa-spinner fa-spin'></i>
                </button>
                <button type="submit" id="voteImage" class="btn btn-danger">
                    Votar Imagenes
                    <i class='d-none load fa fa-spinner fa-spin'></i>
                </button>

                <button type="submit" id="createBlog" class="btn btn-danger">
                    Crear Blogs
                    <i class='d-none load fa fa-spinner fa-spin'></i>
                </button>

                <button type="submit" id="destroyBlog" class="btn btn-danger">
                    Borrar Blogs
                    <i class='d-none load fa fa-spinner fa-spin'></i>
                </button>
            </div>

            <div class="col-9">
                <div class="row">
                    <div class="col-12">
                        {!! Form::textarea('url_blogs',
                        null, ['id' => 'url_blogs',
                        'class'=> 'form-control
                        form-control-sm'])
                        !!}
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        {!! Form::textarea('url_profiles',
                        null,
                        ['id'=>'url_profiles', 'class'=> 'form-control
                        form-control-sm'])
                        !!}
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        {!! Form::textarea('url_images',
                        null,
                        ['id'=>'url_images', 'class'=> 'form-control
                        form-control-sm'])
                        !!}
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <table class="table text-left">
                            <tbody id="debugLog">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-3">
                <ul class="list-group">
                </ul>

                {!! Form::open([ 'id'=>'accountForm',
                'class' => 'mt-2 form-inline', 'method' => 'POST',
                'enctype'=>'multipart/form-data', 'route' =>
                ['uploadAccountFile']]) !!}

                {!! Form::file('account_files', null, []) !!}

                <button type="submit" class="btn btn-danger mt-2">
                    Subir Cuentas
                    <i class='d-none load fa fa-spinner fa-spin'></i>
                </button>
                {!! Form::close() !!}

            </div>
        </div>

        {!! Form::hidden('flagLoading', false, ['id'=>'flagLoading']) !!}
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
