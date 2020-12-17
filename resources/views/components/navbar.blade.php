@php
    $uri = \Route::current()->uri;
@endphp

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top" id="navBar">
	<div class="container-fluid">
		<a class="navbar-brand" href="{{ url('/') }}">
			Event Manager
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
			        <a 
			        	class="nav-link {{ $uri == 'calendar' ? 'active' : '' }}" 
			        	href="{{ route('calendar') }}">
		        		Caledar
		        		<span class="sr-only">(current)</span>
		        	</a>
			    </li>
			    <li class="nav-item active">
			      	<a 
			      		class="nav-link {{ $uri == 'calendar-modified' ? 'active' : '' }}" 
			      		href="{{ route('calendar-modified') }}">
		      			Calendar Modified 
		      			<span class="sr-only">(current)</span>
		      		</a>
			    </li>
			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<!-- Authentication Links -->
				<li class="nav-item dropdown">
					<a class="dropdown-item text-danger" href="{{ route('logout') }}"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
							<path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
						</svg>
						&nbsp;{{ __('Logout') }}
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
				</li>
			</ul>
		</div>
	</div>
</nav> 