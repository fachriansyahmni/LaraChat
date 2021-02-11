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
                        <a href="#">{{$user->name}}</a>
                    </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <h1>
            Message Section
        </h1>
        <div class="chat-body">
            <div class="message-listing" id="messageWrapper">
                <div class="row message align-items-center mb-2">
                    <div class="col-md-12 user-info">
                        <div class="chat-img">
                            
                        </div>
                        <div class="chat-name">
                            Jajang
                            <span class="small time">10:30</span>
                        </div>
                    </div>
                    <div class="col-md-12 message-content">
                        <div class="message-text">
                            asd
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-box">
            <div class="chat-input" id="chatInput" contenteditable="">

            </div>
            <div class="chat-input-toolbar">
                <button title="add file" class="btn btn-light btn-sm btn-file-upload"><i class="fa fa-paperclip"></i></button>
                <button title="bold" class="btn btn-light btn-sm tool-items" onclick="document.execCommand('bold',false,'');"><i class="fa fa-bold tool-icon"></i></button>
                <button title="italic" class="btn btn-light btn-sm tool-items" onclick="document.execCommand('italic',false,'');"><i class="fa fa-italic tool-icon"></i></button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(function(){
            let $chatInput = $(".chat-input");
            let $chatInputToolbar = $('.chat-input-toolbar');
            let $chatBody = $(".chat-body");

            let user_id = "{{Auth::user()->id}}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);
            let friendId = "{{ $friendInfo->id }}";

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

            $chatInput.keypress(function(e){
                let msg = $(this).html();
                if(e.which === 13 && !e.shiftKey){
                    $chatInput.html("");
                    sendMessage(msg);
                    return false;
                }
            });

            function sendMessage(msg){
                let url = "{{ route('message.send-message') }}";
                let form = $(this);
                let formData = new FormData();
                let token = "{{ csrf_token() }}";

                formData.append('message',msg);
                formData.append('_token',token);
                formData.append('receiver_id',friendId);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (resp){
                        if(resp.success){
                            console.log(resp.data);
                        }
                    }
                });
            }
        });
    </script>
@endpush