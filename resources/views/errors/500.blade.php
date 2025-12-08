@php
    $isAdmin = request()->is('admin*') || request()->is('backoffice*');
@endphp

@if($isAdmin)
    {{-- @include('errors.admin') --}}
    @include('errors.frontend')
@else
    @include('errors.frontend')
@endif
