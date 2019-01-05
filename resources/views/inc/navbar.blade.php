<nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="finex 2/public/"><img src="{{URL::asset('/images/finex.jpg')}}" height="50px" style="position:relative;top:-14px"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav" style="float:right">
            <li><a href="login">Login</a></li>
            <li><a href="registration">Register</a></li>
            <li><a href="http://ntu-iic.org">Website</a></li>
            <li><a href="https://www.facebook.com/NTU.IIC/">Facebook</a></li>
            <li><a href="https://www.instagram.com/ntu.iic/">Instagram</a></li>
              @if( auth()->check() )
                  <li>
                      <a href="#">{{ auth()->user()->teamName }}</a>
                      <a href="logout">Logout</a>
                  </li>
              @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
