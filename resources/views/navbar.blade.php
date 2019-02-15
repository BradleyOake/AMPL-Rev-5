<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" style="padding: 5px 0px 5px 0px"><img src="[[asset('/images/logos/ampl-logo-white.svg')]]"  height="40" width="130"></a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="hidden-sm hvr-shutter-out-horizontal [[Request::path() == '/' ? 'active' : '']]"><a href="[[ URL::to('/') ]]">Home</a></li>
                <li class="hvr-shutter-out-horizontal [[Request::path() == 'news' ? 'active' : '']]"><a href="[[ URL::to('news') ]]">Newsroom</a></li>
                <li class="hvr-shutter-out-horizontal [[Request::path() == 'bookstore' ? 'active' : '']]"><a href="[[ URL::to('bookstore') ]]">Bookstore</a></li>
                <li class="hvr-shutter-out-horizontal [[Request::path() == 'aspiring' ? 'active' : '']]"><a href="[[ URL::to('aspiring') ]]">Aspiring Authors</a></li>
                <li class="hvr-shutter-out-horizontal [[Request::path() == 'printingservices' ? 'active' : '']]"><a href="[[ URL::to('printingservices') ]]">Printing Services</a></li>
                <li class="hvr-shutter-out-horizontal [[Request::path() == 'about' ? 'active' : '']]"><a href="[[ URL::to('about') ]]">About Us</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li class="dropdown">
                        <a href="#" id="navName" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            [[ Auth::user()->first_name. " ".Auth::user()->last_name ]] <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation" class="dropdown-header text-center">My Pages</li>

                            @if (Auth::user()->role_id == 7)
                                <li class="[[Request::path() == 'admin' ? 'active' : '']]"><a href="[[ URL::to('admin') ]]"><i class="fa fa-lock fa-fw"></i> Admin Panel</a></li>
                                <li role="presentation" class="divider"></li>
                            @endif
                            <li class="[[Request::path() == 'user/summary' ? 'active' : '']]"><a href="[[ URL::to('user/summary') ]]"><i class="fa fa-home fa-fw"></i> Account Summary</a></li>
                            <li class="[[Request::path() == 'user/transactions' ? 'active' : '']]"><a href="[[ URL::to('user/transactions') ]]" style="padding-left:3em;"><i class="fa fa-exchange fa-fw"></i> Transactions</a></li>
                            <li class="[[Request::path() == 'user/submission' ? 'active' : '']]"><a href="[[ URL::to('user/submission') ]]" style="padding-left:3em;"><i class="fa fa-pencil fa-fw"></i> Submit a Book</a></li>
                            <li class="[[Request::path() == 'user/myPurchases' ? 'active' : '']]"><a href="[[ URL::to('user/myPurchases') ]]" style="padding-left:3em;"><i class="fa fa-cloud-download fa-fw"></i> My Purchases</a></li>
                            <li class="[[Request::path() == 'user/mybooks' ? 'active' : '']]"><a href="[[ URL::to('user/mybooks') ]]" style="padding-left:3em;"><i class="fa fa-book fa-fw"></i> My Written Works</a></li>
                            <li class="[[Request::path() == 'user/sales' ? 'active' : '']]"><a href="[[ URL::to('user/sales/') ]]" style="padding-left:3em;"><i class="fa fa-usd fa-fw"></i> My Sales</a></li>

                            @if (Auth::user()->role_id == 3 )
                                <li class="[[Request::path() == 'editor/assignedBooks' ? 'active' : '']]"><a href="[[ URL::to('editor/assignedBooks') ]]" style="padding-left:3em;"><i class="fa fa-book fa-fw"></i> Assigned Books</a></li>
                            @endif

                            <li role="presentation" class="divider"></li>
                            @if (!Session::has('socialLogin'))
                                <li class="[[Request::path() == 'user/profile' ? 'active' : '']]"><a href="[[ URL::to('user/profile') ]]"><i class="fa fa-cog fa-fw"></i> Account Settings</a></li>
                            @endif
                            <li><a href="[[ URL::to('logout') ]]"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                        </ul>
                    </li>
                @else
                    <li class="hvr-shutter-out-horizontal"><a href="#" data-toggle="modal" data-target="#register_modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="#" class="hvr-shutter-out-horizontal [[Request::path() == 'printingservices' ? 'active' : '']]" data-toggle="modal" data-target="#login_modal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                @endif
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
