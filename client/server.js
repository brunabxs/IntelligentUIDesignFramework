var restify = require('restify');
var server = restify.createServer();

server.use(restify.fullResponse());
server.use(restify.bodyParser());

server.get(/.*/, restify.serveStatic({
  directory: './public'
}));

server.listen(1337, '127.0.0.1', function() {
  console.log('%s listening at %s', server.name, server.url);
});
