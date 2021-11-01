<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>Сообщения</title>
    </head>
    <body>

      <div id="app">

        <v-header myid="{{ $id }}" myip="{{ $ip }}" myname="{{ $name }}"></v-header>
        <!--
        Мой id: {{ $id }}, ip:  {{ $ip }}, Имя: {{ $name }}
      --><br>

        <div class="container">
          <router-view myid="{{ $id }}" myip="{{ $ip }}" myname="{{ $name }}"></router-view>
        </div>
      </div>

      <script src="/js/app.js"></script>

    </body>
</html>
