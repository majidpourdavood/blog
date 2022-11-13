<header class="parent-header" id="header-web">
    <div id="header-web-after">
        <div class="row col-12">

            <nav class="navbar navbar-expand-lg navbar-light nav-tag header" id="header-top">
                <div class="container align-left-container ">

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="/" title="<?php
                    if (isset($indexTitle)) {
                        echo $value = $indexTitle->value;
                    } else {
                        echo $value = '';
                    }
                    ?>"><img class="logo" id="logo" src="<?php
                        if (isset($logo)) {
                            echo $value = $logo->value;
                        } else {
                            echo $value = "/images/new/logo.svg";
                        }
                        ?>" alt="<?php
                        if (isset($indexTitle)) {
                            echo $value = $indexTitle->value;
                        } else {
                            echo $value = '';
                        }
                        ?>"></a>

                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="navbar-nav ul-nav">


                            @foreach($menus as $menu)
                                @if(count($menu->children) > 0)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                           title="{{$menu->title}}" data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false">
                                            {{$menu->title}}
                                            <i class="fas fa-chevron-down "></i>
                                        </a>
                                        <div class="dropdown-menu min-width-14" aria-labelledby="navbarDropdown">
                                            <ul class="list-group row col-12 list-dropdown">

                                                @foreach($menu->children as $children)

                                                    <li class="list-group-item">
                                                        <a class="dropdown-item" title="{{$children->title}}"
                                                           href="{{$children->link}}">
                                                            {{$children->title}}
                                                        </a>
                                                    </li>

                                                @endforeach

                                            </ul>
                                        </div>
                                    </li>


                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" title="{{$menu->title}}"
                                           href="{{$menu->link}}">{{$menu->title}} </a>
                                    </li>

                                @endif
                            @endforeach

                        </ul>

                        <ul class="list-languages">
                            @foreach(\App\Model\Language::where('active', 1)->limit(3)->get() as $language)
                                <li class="nav-item ">
                                    <a class="nav-link" title="{{$language->name}}"
                                       href="{{route('setLanguage', ['local' => $language->iso])}}">{{$language->name}} </a>
                                </li>
                            @endforeach
                        </ul>

                        @if (Route::has('login'))
                            @auth
                                <ul class="list-inline parent-dropdown-auth">
                                    <li class="nav-item dropdown  dropdown-auth">
                                        <a id="navbarDropdown" class=" dropdown-toggle border-0" href="#" role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <i class="fa fa-user"></i>
                                            @if(isset(Auth::user()->name))
                                                {{ Auth::user()->name }} {{ Auth::user()->lastName }}
                                            @else
                                                {{translate('user')}}
                                            @endif
                                            <i class="fas fa-chevron-down "></i>
                                        </a>

                                        <div class="dropdown-menu " aria-labelledby="navbarDropdown">

                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    @if(auth()->user()->hasRole('admin'))
                                                        <a title="{{ translate('User Panel') }}" class="dropdown-item"
                                                           href="{{ route('admin.dashboard') }}">
                                                            {{ translate('User Panel') }}
                                                        </a>

                                                    @endif

                                                </li>

                                                <li class="list-group-item">
                                                    <a title="{{ translate('logout') }}" class="dropdown-item"
                                                       href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                        {{ translate('logout') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>

                                        </div>
                                    </li>
                                </ul>
                            @else
                                <ul class="nav header-login-register">
                                    <li class="nav-item">
                                        <img src="{{asset('images/new/user.svg')}}" class="img-fluid" alt="">
                                    </li>
                                    <li class="nav-item">
                                        <a title="{{translate('login')}}" class="nav-link btn"
                                           href="{{pathUrl(route('login'))}}">

                                            {{translate('login')}}
                                        </a>
                                    </li>

                                </ul>
                            @endauth

                        @endif

                    </div>

                </div>
            </nav>


        </div>
    </div>
</header>
