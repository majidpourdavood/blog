<nav class="navbar fixed-top navbar_panel">


    <ul class="nav justify-content-start parent_toggle_navbar  active">
        <li class="nav-item parent_logo_panel active">
            <a class="text_logo_panel" target="_blank" href="/">
                {{ config('app.name') }}
            </a>
        </li>




        <li class="nav-item parent_menu_panel_icon active">
            <a class="btn menu_panel_icon" href="javascript:void(0)">
                <span></span>
            </a>

        </li>
    </ul>

    <ul class="nav justify-content-end parent_dropdown_panel">

        <li class="list-inline-item parent_bell">
            <a href="{{route('admin.notifications')}}" title="{{ translate('Notifications') }}">
                <i class="fas fa-bell"></i>
                <span class="badge badge-secondary">
                             {{count(auth()->user()->unreadNotifications)}}
                            </span>
            </a>
        </li>

        <li class="nav-item dropdown_panel">
            <a class="nav-link dropdown_toggle_panel" href="#" role="button">
                <img src="{{URL::asset('/images/default_avatar.png')}}" class="img-fluid" alt="">
            </a>

            <div class="dropdown_menu_panel ">
                <ul class="row col-12 list-inline parent_profile_panel_header">
                    <li class="list-inline-item">
                        <div class="">
                            <img src="/images/default_avatar.png" class="img-fluid" alt="">
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <h3>{{auth()->user()->mobile}} </h3>
                        <h6>{{auth()->user()->roles[0]->name}} </h6>
                    </li>
                </ul>

                <ul class="list-group list_top_panel">

                    <ul class="list-languages bg-primary w-100">
                        @foreach(\App\Model\Language::where('active', 1)->limit(3)->get() as $language)
                            <li class="nav-item w-100">
                                <a class="nav-link border-0 btn-block btn btn-dark" title="{{$language->name}}"
                                   href="{{route('setLanguage', ['local' => $language->iso])}}">{{$language->name}} </a>
                            </li>
                        @endforeach
                    </ul>


                    <li class="list-group-item">
                        <a class="btn btn_logout_panel" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i>
                            {{ translate('logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </div>
        </li>
    </ul>


</nav>
<div class="row col-12 content_panel">
    <div id="mySidenav" class="sidenav col m-aside-menu active">
        <ul class="sidebar-nav m-menu__nav " id="accordion">

            <ul class="row col-12 list-inline parent_profile_panel">
                <li class="list-inline-item">
                    <div class="parent_profile_panel_image">
                        <img src="/images/default_avatar.png" class="img-fluid" alt="">
                    </div>
                </li>
                <li class="list-inline-item">
                    <h3>{{auth()->user()->mobile}} </h3>
                    <h3>{{auth()->user()->roles[0]->name}} </h3>
                </li>

            </ul>
            <li id="heading44">
                <a href="{{route('admin.dashboard')}}"
                   class="{{request()->route()->getName() === 'admin.dashboard' ? 'active' : '' }}">

                    <i class=" fa fa-tachometer-alt i_icon_panel"></i>
                    <span class="">{{ translate('Dashboard') }}</span>
                </a>
            </li>

            @if(auth()->user()->hasRole('admin'))

                @if( auth()->user()->can('users.index'))

                    <li id="heading0">
                        <a href="{{route('users.index')}}"
                           class="{{request()->route()->getName() === 'users.index' ? 'active' : '' }}">

                            <i class=" fas fa-users i_icon_panel"></i>
                            <span class="">{{ translate('users') }}</span>
                        </a>
                    </li>
                @endif

                <li class="" id="headingFour">
                    <a href="javascript:void(0)" class=" collapsed" data-toggle="collapse"
                       data-target="#collapseFour"
                       aria-expanded="false" aria-controls="collapseFour">
                        <i class="fa fa-lock i_icon_panel" ></i>
                        {{ translate('permissions') }}-{{ translate('Roles') }}
                        <i class="fa icon_down_up"></i>
                    </a>

                    <ul id="collapseFour" class="collapse list-group list-group-flush " aria-labelledby="headingFour"
                        data-parent="#accordion">
                        <li>
                            <a href="{{route('roles.index')}}"
                               class="{{request()->route()->getName() === 'roles.index' ? 'active' : '' }}">

                                <i class="fas fa-ban" ></i>
                                <span class="">{{ translate('Roles') }} </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('permissions.index')}}"
                               class="{{request()->route()->getName() === 'permissions.index' ? 'active' : '' }}">

                                <i class="fa fa-lock"></i>
                                <span class="">{{ translate('permissions') }} </span>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="" id="headingOne">
                    <a href="javascript:void(0)" class=" collapsed" data-toggle="collapse"
                       data-target="#collapseOne"
                       aria-expanded="false" aria-controls="collapseOne">
                        <i class="fas fa-file-alt i_icon_panel"></i>
                        {{translate('content')}}
                        <i class="fa icon_down_up"></i>
                    </a>

                    <ul id="collapseOne" class="collapse list-group list-group-flush " aria-labelledby="headingOne"
                        data-parent="#accordion">

                        <li id="heading0">
                            <a href="{{route('blog.index')}}"
                               class="{{request()->route()->getName() === 'blog.index' ? 'active' : '' }}">

                                <i class="fab fa-blogger"></i>
                                <span class="">{{ translate('blog') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('menu.index')}}"
                               class="{{request()->route()->getName() === 'menu.index' ? 'active' : '' }}">

                                <i class="fas fa-bars"></i>
                                <span class="">{{ translate('Menus') }}</span>
                            </a>
                        </li>


                        <li>
                            <a href="{{route('translation.index')}}"
                               class="{{request()->route()->getName() === 'translation.index' ? 'active' : '' }}">

                                <i class="fas fa-language"></i>
                                <span class=""> {{ translate('Translations') }}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('category.index')}}"
                               class="{{request()->route()->getName() === 'category.index' ? 'active' : '' }}">

                                <i class=" fa fa-list "></i>
                                <span class="">{{ translate('Categories') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>




                <li class="" id="headingTwo">
                    <a href="javascript:void(0)" class=" collapsed" data-toggle="collapse"
                       data-target="#collapseTwo"
                       aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-envelope i_icon_panel"></i>
                        {{translate('Support')}}
                        <i class="fa icon_down_up"></i>
                    </a>

                    <ul id="collapseTwo" class="collapse list-group list-group-flush "
                        aria-labelledby="headingTwo"
                        data-parent="#accordion">

                        <li>
                            <a href="{{route('comment.index')}}"
                               class="{{request()->route()->getName() === 'comment.index' ? 'active' : '' }}">
                                <i class="fa fa-comments "></i>
                                <span class="">{{ translate('Comments') }}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('admin.notifications')}}"
                               class="{{request()->route()->getName() === 'admin.notifications' ? 'active' : '' }}">
                                <i class="fas fa-bell "></i>
                                <span class="">{{ translate('Notifications') }}  </span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="" id="headingThree">
                    <a href="javascript:void(0)" class=" collapsed" data-toggle="collapse"
                       data-target="#collapseThree"
                       aria-expanded="false" aria-controls="collapseThree">
                        <i class="fas fa-cogs i_icon_panel"></i>
                        {{ translate('Settings') }}
                        <i class="fa icon_down_up"></i>
                    </a>

                    <ul id="collapseThree" class="collapse list-group list-group-flush "
                        aria-labelledby="headingThree"
                        data-parent="#accordion">


                        <li>
                            <a href="{{route('getManageSite')}}"
                               class="{{request()->route()->getName() === 'getManageSite' ? 'active' : '' }}">

                                <i class=" fas fa-magnet "></i>
                                <span class="">{{ translate('site management') }}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('setting.index')}}"
                               class="{{request()->route()->getName() === 'setting.index' ? 'active' : '' }}">

                                <i class=" fas fa-newspaper "></i>
                                <span class="">{{ translate('Settings') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                    <li id="heading33">
                        <a href="{{route('cacheClear')}}"
                           class="{{request()->route()->getName() === 'cacheClear' ? 'active' : '' }}">

                            <i class="fas fa-envelope-open i_icon_panel"></i>
                            <span class="">{{ translate('Clear Cache') }}  </span>
                        </a>
                    </li>
                    <li id="heading99">
                        <a href="{{route('index')}}" target="_blank"
                           class="{{request()->route()->getName() === 'index' ? 'active' : '' }}">

                            <i class="fa fa-globe i_icon_panel"></i>
                            <span class="">{{ translate('show website') }}  </span>
                        </a>
                    </li>
            @endif

        </ul>

    </div>
    <div class="col main_content_panel active">
        @yield('content')
    </div>

</div>


