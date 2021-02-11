var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var users = [];

var port = 8005;
http.listen(port, function () {
    console.log("listening port " + port);
});

io.on('connection', function (socket) {
    socket.on('user_connected', function (user_id) {
        users[user_id] = socket.id;
        io.emit('updateUserStatus', users);
        console.log("User Connected " + user_id);
    });

    socket.on('disconnect', function () {
        var i = users.indexOf(socket.id);
        users.splice(i, 1, 0);
        io.emit('updateUserStatus', users);
        console.log(users);
    });
});