const wsModule = require("ws");

module.exports = function(_port) {
	//웹소켓 서버 생성
	const wss = new wsModule.Server({ port : _port });
	console.log('접속 요청중');
	//접속 처리 이벤트
	wss.on('connection', function(ws, req) {
		//ip 확인
		let ip = req.headers['x-forwarded-for'] || req.connection.remoteAddress;
		console.log(ip + "의 아이피로 접속 요청 발생");

		//메시지 처리 이벤트
		ws.on('message', function(msg) {
			//받은 메시지 출력
			console.log(ip + "로부터 받은 메시지 : " + msg);
			wss.clients.forEach(function (client) {
				if (client.readyState == wsModule.OPEN) {
					client.send(JSON.stringify(req));
				}
			});

			//받은 메시지 전송
			//ws.send("받은 메시지 : " + msg);
		});
		//오류 처리 이벤트
		ws.on('error', function(error) {
			console.log(ip + " 클라이언트와 연결중 오류발생 : " + error);
		});
		//종료 처리 이벤트
		ws.on('close', function() {
			console.log(ip + " 클라이언트와 접속 해제");
		});
	});
}
