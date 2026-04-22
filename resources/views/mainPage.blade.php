
@extends("layouts.defaultLayout")
@section("title","Home")

@section("mainContent")

    <div id="page"  data-page="home" ></div>

    <div class="vue-mount" data-component="Brands"  ></div>
    <div class="banner">
        <div class="banner__content">
            <h2>{{ __("messages.welcome") }}</h2>
            <p>{{__("messages.welcomeUnderline") }}</p>
            <img src="{{asset("/images_general/horse.webp")}}" alt="logo">
        </div>
    </div>

    <div class="vue-mount" data-component="NewsFeed" data-endpoint="{{route("api.news")}}" ></div>

    <div class="container">

        <h2>{{__("messages.welcomeTextH2")}}</h2>
        <p>{{ __("messages.welcomeText1") }}</p>
        <img src="{{asset("/images/defaultPic.jpg")}}"  >
        <p>{{ __("messages.welcomeText2") }}</p>
        <p>{{ __("messages.welcomeText3") }}</p>
        <p>{{ __("messages.welcomeText4") }}</p>

    </div>

    <div  class="favCategory">
    <h2 class="favCategory__h2" >Lieblingskategorien </h2>
    <div class="favCategory__list">

        <a href="{{ __("messages.routes.rider") }}" class="favCategory__item">
            <img src="{{asset("/images/defaultPic.jpg")}}" alt="Reithosen" class="favCategory__img">
            <h4 class="favCategory__h4"  > {{ __("messages.routes.rider") }}</h4>
    </a>

        <a href="{{ __("messages.routes.horses") }}" class="favCategory__item">
            <img src="{{asset("/images/defaultPic.jpg")}}" alt="Reitstiefel" class="favCategory__img">
            <h4 class="favCategory__h4">{{ __("messages.routes.horses") }}</h4>
        </a>

        <a href="{{ __("messages.routes.garden") }}" class="favCategory__item">
            <img src="{{asset("/images/boots.jpg")}}" alt="Reithelme" class="favCategory__img">
            <h4 class="favCategory__h4" >{{ __("messages.routes.garden") }}</h4>
        </a>
        <a href="{{ __("messages.routes.animalfeed") }}" class="favCategory__item">
            <img src="{{asset("/images/defaultPic.jpg")}}" alt="Reithelme" class="favCategory__img">
            <h4 class="favCategory__h4" >{{ __("messages.routes.animalfeed") }}</h4>
        </a>

    </div>
    </div>

    <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2512.6531008233733!2d5.9761837!3d50.967117699999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c0bbc3c9db6993%3A0x82d0ca9c1369cd1!2sRuitersport%20Limburg!5e0!3m2!1sde!2sde!4v1776124083198!5m2!1sde!2sde"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>


@endsection
