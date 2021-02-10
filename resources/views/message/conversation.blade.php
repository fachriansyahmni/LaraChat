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
