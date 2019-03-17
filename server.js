var http = require('http').Server();
// var http = require('http').Server();
var io = require('socket.io')(http);

var Redis = require('ioredis');

var redis = new Redis();

redis.psubscribe('chats.*');
redis.psubscribe("like.*");

redis.addListener('pmessage', function (pattern, channel, message) {
   console.log('Message recived:' + message);
   console.log('Chanel_like:' + channel);
   console.log('pattern_like:' + pattern) ;
   message = JSON.parse(message);
   io.emit(channel, message);
   io.on('disconnect', function () {
      redis.quit();
   })
});
// io.sockets.on()
// redis.addListener('pmessage', on)

// io.sockets.on('connection', function (client) {
//
//    redis.psubscribe('chats.*');
//    redis.psubscribe("like.*");
//
//    redis.on("pmessage", function(pattern, channel, message) {
//       console.log('Message recived:' + message);
//       console.log('Chanel_like:' + channel);
//       console.log('pattern_like:' + pattern) ;
//       client.send(message);
//    });

   // client.on('message', function(msg) {
   //    console.log('conection');
   // });
   //
   // client.on('disconnect', function() {
   //    redis.quit();
   // });
// });

http.listen(3000, function () {
   console.log('Listening on Port: 3000');
});
