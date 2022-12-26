<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aktualna pogoda</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="antialiased">

        <div class="container">
            <div class="mt-5 weather-box">
                <h1 class="text-center">Aktualna pogoda</h1>
                @if(isset($temperature) && isset($country) && isset($city))
                    <div class="temperature-box text-center">
                        <h1 class="text-center">{{ $city }}, {{ $country }}</h1>
                        <div class="temp text-center">@if($temperature >= 0) + @endif{{ number_format($temperature) }}<sup>&deg;</sup></div>
                        <a href="/" class="btn btn-primary">Powrót</a>
                    </div>
                @else
                    <form method="POST" action="/submit">
                        @csrf
                        <div class="mb-3">
                            <label for="country" class="form-label">Kraj (zalecany w języku angielskim)</label>
                            <input
                                type="text"
                                class="form-control"
                                id="country"
                                name="country"
                                value="{{ old('country', '') }}"
                            >
                            @error('country')
                                <div class="form-text text-danger">W polu kraj wystąpił błąd</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Miasto</label>
                            <input
                                type="text"
                                class="form-control"
                                id="city"
                                name="city"
                                value="{{ old('city', '') }}"
                            >
                            @error('city')
                                <div class="form-text text-danger">W polu miasto wystąpił błąd</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Wyślij</button>

                        @if (session()->has('errorAPI'))
                            <div class="alert alert-danger mt-3" role="alert">
                                {{ session()->get('errorAPI') }}
                            </div>
                        @endif
                    </form>
                @endif
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>
