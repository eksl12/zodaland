const express = require('express')
const request = require('request')
const cookieParser = require('cookie-parser')
const ejs = require('ejs')
const path = require('path')

//익스프레스 기본 셋팅
const app = express()
const port = 9004

//템플릿 엔진 사용 선언
app.set('view engine', 'ejs')
app.set('views', './public')

//바디 파싱
app.use(express.urlencoded({ extended: true }))
app.use(express.json())
//쿠키 파싱
app.use(cookieParser())

//디렉터리 지정
app.use(express.static(path.join(__dirname, 'public')))
//뷰단 라우터 임포트
const router = require('./routes/index')
app.use('/', router)
//테스트 라우터 임포트
const testRouter = require('./routes/test')
app.use('/', testRouter)
//jwt config 임포트
const jwtConfig = require('./config/jwt_config')
app.set('jwt-secret', jwtConfig.secretKey)


app.use((req, res, next) => {
	res.status(404).send('잘못된 접근입니다.')
});

app.use((err, req, res, next) => {
	console.error(err.stack)
	res.status(500).send('서버 에러')
});

app.listen(port, function() {
	console.log("ver. websocket open")
	console.log('listening on port ' + port)
});

