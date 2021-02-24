const jwt = require('jsonwebtoken');

const authMiddleware = (req, res, next) => {
	const token = req.headers['x-access-token'] || req.query.token

	if (!token) {
		return res.status(403).json({
			code: 9999,
			message: 'not exist token'
		})
	}

	const p = new Promise((resolve, reject) => {
		jwt.verify(token, req.app.get('jwt-secret'), (err, decoded) => {
			if(err) {
				reject(err)
			}
			resolve(decoded)
		})
	})

	const onError = (error) => {
		res.status(403).json({
			code: 9998,
			message: error.message
		})
	}

	p.then((decoded) => {
		req.decoded = decoded
		console.log(decoded)
		next()
	})
	.catch(onError)
}

module.exports = authMiddleware
