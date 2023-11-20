@section('profile')

<section id="profile">
    <h1>{{ $user->name }}</h1>
    <img src="{{$user->profilePicture}}">
    <p>{{ $user->email }}</p>
    <p>{{ $user->score }}</p>
    @if(Auth::user()->user_id == $user->user_id)
        <a class="button" href="{{ url('/user/'.$user->user_id.'/edit') }}"> Edit Profile</a>
    @endif
</section>

@endsection