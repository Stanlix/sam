<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Stanlix AM</title>

        <!-- Styles -->
        <style>

            body, html {
                height: 100%;
                background-color: #333;
            }
            .wrapper {
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .btn {
                font-size: 1.2rem;
                padding: 10px 20px;
                border: none;
                /* box-shadow: 1px 1px 1px #555; */
                box-shadow: 1px 1px 1px 0px #5CA4FF;
                background-color: #010182;

                color: #fff;
                border-radius: 3px;
                outline:none;
            }
            .btn:active {
                box-shadow: 1px 1px 0 #999;
                background-color: #281293;
            }
        </style>
        <script type="text/javascript">
            
            window.WEBSOCKETS_CONFIG = {
                HOST: "{{ env('LARAVEL_WEBSOCKETS_HOST') }}",
                PORT: "{{ env('LARAVEL_WEBSOCKETS_PORT') }}",
                APP_KEY: "{{ env('PUSHER_APP_KEY') }}", 
            };
            
        </script>
    </head>
    <body>
        <section id="app" class="wrapper">
            <button class="btn btn-primary">Deploy</button>
        </section>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
