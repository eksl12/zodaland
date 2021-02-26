const router = require('express').Router()
const auth = require('./auth')
const room = require('./room')
const invitation = require('./invitation')

router.use('/auth', auth)
router.use('/room', room)
router.use('/invitation', invitation)

module.exports = router
