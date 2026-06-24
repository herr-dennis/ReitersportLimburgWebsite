<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @vite(['resources/css/app.scss','resources/js/app.js'])
    <meta charset="UTF-8">
    <meta property="og:locale" content="{{ app()->getLocale() === 'de' ? 'de_DE' : 'nl_NL' }}">

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>

</head>
<body>
<div id="consent"></div>
<header>
    <div id="nav"></div>
</header>

<main>
    <a href="/{{__("messages.routes.contact")}}" class="contact-float">
        <div class="contact-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.1" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>

        </div>
    </a>
    @section("mainContent")


    @show
</main>

<footer>
    @section("footer")
        <div class="footerContainer" >
            <a href="/{{__("messages.routes.impressum")}}">{{__("messages.routes.impressum")}}</a>
            <a href="/{{__("messages.routes.dataprotection")}}" >{{__("messages.routes.dataprotection")}}</a>
        </div>
    @show
</footer>



</body>
</html>
