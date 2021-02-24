const router = require('express').Router()
const controller = require('./controller')
const authMiddleware = require('../../middlewares/auth')

router.post('/register', controller.register)
//router.get('/user/:id', controller.user)
router.post('/login', controller.login)

router.use('/check', authMiddleware)

module.exports = router
