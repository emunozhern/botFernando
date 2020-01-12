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
        /* html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            } */

        .title {
            font-size: 84px;
        }

        /* .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            } */
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="title text-center
                "> Bot Fernando</h1>
                <div class="row">
                    <div class="col-9">
                        {!! Form::textarea('linkList', null, ['id'=>'urls', 'class'=> 'form-control form-control-sm'])
                        !!}
                    </div>

                    <div class="col-3">
                        {!! Form::textarea('user:List', null, ['id'=>'users', 'class'=> 'form-control form-control-sm'])
                        !!}
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                {!! Form::submit('Iniciar', ['id'=>'startBot', 'class' => 'btn btn-primary']) !!}
                {!! Form::submit('Deneter', ['id'=>'stopBot', 'class' => 'btn btn-danger']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-3">
                <table class="table text-left">
                    <tbody id="debugLog">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>