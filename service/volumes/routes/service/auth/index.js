const router = require('express').Router()
const controller = require('./controller')

router.post('/register', controller.register)
router.use('/complete', (req, res) => {
	res.render('main')
})
router.post('/login', controller.login)

module.exports = router
