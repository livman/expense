@include('header')

<form method="POST" action="/user/create">
    {{ csrf_field() }}
    username: <input name="username" type="text" value="" />
    password: <input name="password" type="password" value="" />
    <input type="submit" name="submit" />
</form>

@include('footer')