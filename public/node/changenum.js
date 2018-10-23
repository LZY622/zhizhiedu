// 引入express并且创建应用
var app = require('express')();
// 引入mysql模块
var mysql= require('mysql');
// 创建http服务
var server = require('http').createServer(app);
// 引入socket并且创建使用
var io = require('socket.io')(server);
var new_num = '';
server.listen(3389);

app.get('/',function(req, res){
	io.on('connection', function (socket) {
		console.log("new client connected");
	    //监听客户端发送的消息
	    socket.on('howmany', function (data) {
	    	var connection = mysql.createConnection({
	            host : 'localhost',
				database : 'dianting',
				user : 'root',
				password : 'liziyue147',
				useConnectionPooling: true
	        });
	        //链接数据库
	        connection.connect();
	        //执行sql语句
	        connection.query('select * from zz_msm where `status`="0"',function (error, results, fields) {
	            //判断链接错误
	            if (error) throw error;
	            //打印结果
	            new_num = results.length;
	            console.log(new_num);
	            // console.log(data.num);
	            if (new_num != data.num) {
	            	socket.emit('new_num', { 'new_num': results });
	            }else{
            		var init = setInterval(function(){
	            		connection.query('select * from zz_msm where `status`="0"',function selectnew(newerror, newresults, newfields){
	            			if (newerror) throw newerror;
	            			new_num = newresults.length;;
	            			if(new_num != data.num){
	            				clearInterval(init);
	            				socket.emit('new_num', { 'new_num': newresults });
	            			}
	            		});
	            	},3000);
	            }
	        });
	        
	        // //断开连接数据库
	        // connection.end(); 
	    });
	});
});
