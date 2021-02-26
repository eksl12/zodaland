const user = require('../../models/user')
const hash = require('../../library/hash')

exports.register = (req, res) => {
	const body = req.body
	var password = body.password

	const checkValue = (con) => {
		return new Promise((resolve, reject) => {
			if (body.id === undefined || body.password === undefined || body.name === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			resolve(body.id)	
		})
	}

	const checkDuplicateUser = (result) => {
		var count = result[0].count

		return new Promise((resolve, reject) => {
			if (count > 0) {
				reject({
					code: '9998',
					message: 'already exist user'
				})
			} else {
				const hashPassword = hash.convert(password)
				const params = [ body.id, hashPassword, body.name]
				resolve(params)
			}
		});
	}

	const respond = (result) => {
		res.json({
			code: '0000',
			message: 'create complete'
		})
	}
	
	const respondError = (error) => {
		res.status(409).json(error);
	}

	checkValue()
	.then(user.getConnection)
	.then(user.find)
	.then(checkDuplicateUser)
	.then(user.getConnection)
	.then(user.create)
	.then(respond)	
	.catch(respondError)
}

exports.login = (req, res) => {
	var body = req.body
	var password = body.password

	const checkValue = (con) => {
		return new Promise((resolve, reject) => {
			if (body.id === undefined || body.password === undefined) {
				reject({
					code: '9999',
					message: 'not found id'
				})
			}
			resolve(body.id)
		})
	}

	const checkUser = (result) => {
		var count = result[0].count

		return new Promise((resolve, reject) => {
			if (count === 0) {
				reject({
					code: '9997',
					message: 'not found user'
				})
			} else {
				const hashPassword = hash.convert(password)
				const params = [ body.id, hashPassword ]
				resolve(params)
			}
		});
	}

	const checkLogin = (user) => {
		return new Promise((resolve, reject) => {
			if (user.length === 0) {
				reject({
					code: '9990',
					message: 'login failed'
				})
			} else {
				resolve(user)
			}
		})
	}

	const respond = (user) => {
		res.json({
			code: '0000',
			user: user
		})
	}

	const respondError = (error) => {
		res.status(403).json(error)
	}

	checkValue()
	.then(user.getConnection)
	.then(user.find)
	.then(checkUser)
	.then(user.getConnection)
	.then(user.verify)
	.then(checkLogin)
	.then(respond)
	.catch(respondError)
}
