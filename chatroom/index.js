var app = require('express')()
var http = require('http').Server(app)
var io = require('socket.io')(http)

var sql = require('mssql')

io.on('connection', function(socket){
  socket.on('room', function(room) {
    socket.join(room);
  })

  console.log('a user connected')
  socket.on('disconnect', function(){
    console.log('a user has left')
  })

  socket.on('chat message', function(data){
    console.log(data)
    io.to(data.room).emit('chat message', data.msg)
  })
})

http.listen(3000, function(){
  console.log('listening on *:3000')
})
