const router = require('express').Router()
const controller = require('./controller')

router.use('/:roomNo/user/:userNo', controller.findRoom)

module.exports = router
