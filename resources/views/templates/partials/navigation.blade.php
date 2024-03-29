<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('home')}}"><STRONG>RAIT HUB</STRONG></a>
        </div>
        <div class="collapse navbar-collapse">
            @if (Auth::check())
                <ul class="nav navbar-nav">
                    <li><a href="{{route('home')}}">News</a></li>
                    <li><a href="{{route('home')}}">Committee news</a></li>
                    <li><a href="{{route('home')}}">Alumni news</a></li>
                    <li><a href="{{route('home')}}">Timeline</a></li>
                    <li><a href="{{route('friend.index')}}">Requests</a></li>
                </ul>
                <form class="navbar-form navbar-left" role="search" action="{{route('search.results')}}">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="Find users">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
             @endif
            <ul class="nav navbar-nav navbar-right">
                 @if (Auth::check())
                    <!--<li><a href="{{route('profile.index',['username'=>Auth::user()->username])}}">{{Auth::user()->getNameOrUsername()}}</a></li>!-->
                    <li><a href="{{route('profile.edit')}}">Update profile</a></li>
                    <li><a href="{{route('auth.signout')}}">Sign out</a></li>
                @else
                    <li><a href="{{route('auth.signup')}}"><STRONG>Sign up</STRONG></a></li>
                    <li><a href="{{route('auth.signin')}}"><STRONG>Sign in</STRONG></a></li>
                @endif 
            </ul>
        </div>
    </div>
</nav>
