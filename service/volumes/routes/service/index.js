const router = require('express').Router();
const auth = require('./auth')
const error = require('./error')

router.use('/auth', auth);

router.use('/error',error);

module.exports = router;
