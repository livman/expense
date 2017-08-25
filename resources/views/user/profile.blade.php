@include('header')

<div class="flex-center position-ref full-height">
    @if ($user)
        {{ $user->username }}
    @endif
</div>

@include('footer')