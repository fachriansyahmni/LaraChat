@extends('layouts.app')

@section('content')
<div class="row chat-row">
    <div class="col-md-3">
        <div class="users">
            <h5>Users</h5>
            <ul class="list-group list-chat-item">
                @if ($users->count())
                    @foreach ($users as $user)
                    <li class="chat-user-list">
                        <i class="fa fa-circle user-status-icon user-icon-{{$user->id}}"></i>
                        <a href="{{route('message.conversation',$user->id)}}">{{$user->name}}</a>
                    </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="col-md-9">

    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(function(){
            let user_id = "{{Auth::user()->id}}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);

            socket.on('connect',function(){
                socket.emit('user_connected',user_id);
            });
            socket.on('updateUserStatus', (data)=>{
                let $userStatusIcon = $('.user-status-icon');
                $userStatusIcon.removeClass('text-success');
                console.log(data);
                $.each(data, function(key, val){
                    if(val !== null && val !== 0){
                        console.log(key);
                        let $userIcon = $(".user-icon-"+key);
                        $userIcon.addClass('text-success');
                    }
                });
            });
        });
    </script>
@endpush
