const roomUser = require('../../../models/room_user')
const room = require('../../../models/room')
const user = require('../../../models/user')

const checkValidation = (param) => {
	const checkRoom = (result) => {
		return new Promise((resolve, reject) => {
			if (result.length === 0) {
				reject({
					code: '9997',
					message: 'invalid roomNo'
				})
			}
			resolve(param[0])
		})
	}

	const checkUser = (result) => {
		return new Promise((resolve,reject) => {
			if (result[0].count === 0) {
				reject({
					code: '9997',
					message: 'invalid userNo'
				})
			}
			resolve()
		})
	}

	const respond = () => {
		return {
			code: '0000',
			data: param
		}
	}

	const respondError = (error) => {
		return error
	}


	room.getConnection(param[1])
	.then(room.find)
	.then(checkRoom)
	.then(user.getConnection)
	.then(user.find)
	.then(checkUser)
	.then(respond)
	.catch(respondError)

return 'asd';
}

exports.create = (req, res) => {
	
}

exports.findRoom = (req, res) => {
	const params = req.params
	const roomNo = params.roomNo
	const userNo = params.userNo

	const checkValue = () => {
		return new Promise((resolve, reject) => {
			if (roomNo === undefined || userNo === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			resolve([ userNo, roomNo ])
		})
	}

	const checkRoom = (result) => {
		return new Promise((resolve, reject) => {
			if (result.length === 0) {
				reject({
					code: '9997',
					message: 'invalid roomNo'
				})
			}
			resolve(userNo)
		})
	}

	const checkUser = (result) => {
		return new Promise((resolve,reject) => {
			if (result.length === 0) {
				reject({
					code: '9997',
					message: 'invalid userNo'
				})
			}
			resolve([ userNo, roomNo ])
		})
	}

	const checkResponse = (result) => {
		return new Promise((resolve, reject) => {
			if (result.length === 0) {
				reject({
					code: '9997',
					message: 'not found data'
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
			console.log(error)
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


/*
	.then(room.getConnection)
	.then(room.find)
	.then(checkRoom)
	.then(user.getConnection)
	.then(user.find)
	.then(checkUser)
*/
	checkValue()
	.then(checkValidation)
	.then((data) => {
	console.log(data)
	roomUser.getConnection
	})
	.then(roomUser.findRoom)
	.then(checkResponse)
	.then(respond)
	.catch(respondError)
}
