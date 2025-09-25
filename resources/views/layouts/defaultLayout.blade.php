<!doctype html>
<html lang="de">
<head>
    @vite(['resources/css/app.scss','resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>

</head>
<body>

<header>
    @section("header")

      <nav class="nav">
          <ul class="nav__ul">
              <li class="nav__li" >Home</li>
              <li class="nav__li" >Reiter</li>
          </ul>
      </nav>

    @show
</header>

<main>
    @section("mainContent")

    @show
</main>

<footer>
    @section("footer")
        <div class="footerContainer" >
            <a>Impressum</a>
            <a>Datenschutz</a>
        </div>
    @show
</footer>



</body>
</html>
