const room = require('../../models/room')

exports.create = (req, res) => {
	const body = req.body
	
	if (body.isPrivate === undefined) {
		res
		.status(409)
		.json({
			code: '9999',
			message: 'invalid value'
		})
		
		return
	}

	const isPrivate = body.isPrivate || 0
	
	const checkValue = () => {
		return new Promise((resolve, reject) => {
			if (isPrivate !== '0' && isPrivate !== '1') {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			resolve(isPrivate)
		})
	}

	const respond = (result) => {
		res.json({
			code: '0000',
			data: result.insertId
		})
	}

	const respondError = (error) => {
		var result = {}

		if (error.code === undefined) {
			result = {
				code: '9000',
				message: 'connection error'
			}
		} else {
			result = error
		}
		res
		.status(409)
		.json(result)
	}
	
	checkValue()
	.then(room.getConnection)
	.then(room.create)
	.then(respond)
	.catch(respondError)
}

exports.find = (req, res) => {
	const params = req.params
	const no = params.no

	const checkValue = () => {
		return new Promise((resolve, reject) => {
			if (no === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			resolve(no)
		})
	}

	const checkResponse = (result) => {
		return new Promise((resolve, reject) => {
			if (result.length === 0) {
				reject({
					code: '9997',
					message: 'not exist data'
				})
			}
			resolve(result)
		})
	}

	const respond = (result) => {
		res.json({
			code: '0000',
			data: result
		})
	}

	const respondError = (error) => {
		var result = {}

		if (error.code === undefined) {
			result = {
				code: '9000',
				message: 'connection error'
			}
		} else {
			result = error
		}
		res
		.status(409)
		.json(result)
	}
	
	checkValue()
	.then(room.getConnection)
	.then(room.find)
	.then(checkResponse)
	.then(respond)
	.catch(respondError)
}

exports.delete = (req, res) => {
	const params = req.params
	const no = params.no

	const checkValue = () => {
		return new Promise((resolve, reject) => {
			if (no === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			resolve(no)
		})
	}

	const respond = (result) => {
		res.json({
			code: '0000',
			data: result.affectedRows
		})
	}

	const respondError = (error) => {
		var result = {}

		if (error.code === undefined) {
			result = {
				code: '9000',
				message: 'connection error'
			}
		} else {
			result = error
		}
		res
		.status(409)
		.json(result)
	}
	
	checkValue()
	.then(room.getConnection)
	.then(room.delete)
	.then(respond)
	.catch(respondError)
	
}
