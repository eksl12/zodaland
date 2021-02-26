const invitation = require('../../models/invitation')
const room = require('../../models/room')
const user = require('../../models/user')

exports.create = (req, res) => {
	const body = req.body
	const params = [ body.roomNo, body.inviteUserNo, body.invitedUserNo ]

	const checkValue = () => {
		return new Promise((resolve, reject) => {
			if (body.roomNo === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			
			if (body.inviteUserNo === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			if (body.invitedUserNo === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			resolve(body.roomNo)
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
			resolve(body.inviteUserNo)
		})
	}

	const checkUser = (result) => {
		return new Promise((resolve, reject) => {
			if (result.length === 0) {
				reject({
					code: '9997',
					message: 'invalid UserId'
				})
			}
			resolve(body.invitedUserNo)
		})
	}

	const respond = (result) => {
		res
		.json({
			code: '0000',
			data: result
		})
	}

	const respondError = (error) => {
		var result = {}

		if (result.code === undefined) {
			result = {
				code: '9000',
				message: 'connection error'
			}
		} else {
			result = error
		}
		res
		.status(409)
		.json(error)
	}

	checkValue()
	.then(room.getConnection)
	.then(room.find)
	.then(checkRoom)
	.then(user.getConnection)
	.then(user.find)
	.then(checkUser)
	.then(user.getConnection)
	.then(user.find)
	.then(checkUser)
	.then(invitation.getConnection)
	.then(invitation.create)
	.then(respond)
	.catch(respondError)
}

exports.findByInviteUser = (req, res) => {
	const params = req.params
	const inviteUserNo = params.no

	const checkValue = () => {
		return new Promise((resolve, reject) => {
			if (inviteUserNo === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			resolve(inviteUserNo)
		})
	}

	const respond = (result) => {
		res
		.json({
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
	.then(invitation.getConnection)
	.then(invitation.findByInviteUser)
	.then(respond)
	.catch(respondError)
}

exports.findByInvitedUser = (req, res) => {
	const params = req.params
	const invitedUserNo = params.no

	const checkValue = () => {
		return new Promise((resolve, reject) => {
			if (invitedUserNo === undefined) {
				reject({
					code: '9999',
					message: 'invalid value'
				})
			}
			resolve(invitedUserNo)
		})
	}

	const respond = (result) => {
		res
		.json({
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
	.then(invitation.getConnection)
	.then(invitation.findByInvitedUser)
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
	.then(invitation.getConnection)
	.then(invitation.delete)
	.then(respond)
	.catch(respondError)
	
}
