const user = require('../../models/user')
const hash = require('../../library/hash')
const jwt = require('jsonwebtoken')

exports.register = (req, res) => {
	const body = req.body
	var password = body.password
	var hashPassword = hash.convert(password)
	var param = [ body.id, hashPassword, body.name ]

	const findUserById = (con) => {
		if (!body.id) {
			throw new Error({
				code: '9999',
				message: 'not found id'
			})
		} else {
			return user.find(con, body.id)
		}
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
				resolve(user.getConnection())
			}
		});
	}

	const create = (con) => {
		return user.create(con, param)
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

	user.getConnection()
	.then(findUserById)
	.then(checkDuplicateUser)
	.then(create)
	.then(respond)	
	.catch(respondError)
}

exports.login = (req, res) => {
	var body = req.body
	var password = body.password
	var hashPassword = hash.convert(password)
	var param = [ body.id, hashPassword ]

	const findUserById = (con) => {
		return new Promise((resolve, reject) => {
			if (!body.id) {
				reject({
					code: '9999',
					message: 'not found id'
				})
			}
			
			user.find(con, body.id)
			.then((result) => {
				resolve(result)
			})
			.catch((err) => {
				reject({
					code: '9000',
					message: 'db error'
				})
			})
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
				resolve(user.getConnection())
			}
		});
	}

	const login = (con) => {
		return user.verify(con, param)
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

	user.getConnection()
	.then(findUserById)
	.then(checkUser)
	.then(login)
	.then(checkLogin)
	.then(respond)
	.catch(respondError)
}
