@extends('content/layouts/main')
@section('content')
<div class="profile-menu">
    <div class="profile-header">
    </div>
    <ul class="profile-options">
        <li><a href="{{ route('login') }}"><i class="fas fa-user fa-fw"></i> Account</a></li>
        <li><a href="#"><i class="fas fa-cog fa-fw"></i> Setting</a></li>
        <li><a href="#"><i class="fas fa-dollar-sign fa-fw"></i> Billing</a></li>
        <li class="logout"><a href="#"><i class="fas fa-power-off fa-fw"></i> Logout</a></li>
    </ul>
</div>
@endsection