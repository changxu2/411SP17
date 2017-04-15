var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
  res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
  console.log('a user connected');
  socket.on('disconnect', function(){
    console.log('a user has left')
  })

  socket.on('chat message', function(data){
    console.log(data)
    io.emit('chat message', data)
  })
});

http.listen(3000, function(){
  console.log('listening on *:3000');
});
