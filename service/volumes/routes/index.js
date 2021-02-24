const express = require('express')
const service = require('./service')

var router = express.Router()

router.use('/ws', (req, res) => {
	res.render('websocket')
})


router.get('/reg', (req, res) => {
    res.render('regist')
})


router.get('/login', (req, res) => {
    res.render('login')
})

router.use('/', service)

router.get('/', (req, res) => {
    res.render('main')
})


module.exports = router
