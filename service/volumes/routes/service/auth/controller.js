const request = require('request')
const jwt = require('jsonwebtoken')
const lang = require('../../../library/language_pack/service').authLang
const hash = require('../../../library/hash')

exports.register = (req, res) => {
	const body = req.body
	
	const checkValidation = (body) => {
		return new Promise((resolve, reject) => {
			const id = body.id
			const password = body.password
			const name = body.name
			const idPattern = /^[a-zA-Z0-9]{5,15}$/
			const namePattern = /^[a-zA-Z0-9가-힣]{2,10}$/

			if (idPattern.test(id) === false) {
				reject({
					success: false,
					message: lang.invalid_id
				})
			}
			if (password.length < 4 || password.length > 20) {
				reject({
					success: false,
					message: lang.invalid_password
				})
			}
			if (namePattern.test(name) === false) {
				reject({
					success: false,
					message: lang.invalid_name
				})
			}
			
			resolve()
		})
	}

	const create = () => {
		const options = {
				headers: {'content-type': 'application/json'},
				url: 'https://api.zodaland.com/auth/register',
				method: 'POST',
				form: {
					id: body.id,
					password: body.password,
					name: body.name
				}
			}

		return new Promise((resolve, reject) => {
				request(options, (err, res, body) => {
				if (err) {
					reject({
						success: false,
						message: lang.request_failure
					})
				}
				resolve(body)
			})
		})
	}

	const checkData = (result) => {
		const data = JSON.parse(result)
		return new Promise((resolve, reject) => {
			switch (data.code) {
				case '9999':
					reject({
						success: false,
						message: lang.no_id
					})
					break
				case '9998':
					reject ({
						success: false,
						message: lang.already_exist_id
					})
					break
				case '0000':
					resolve()
					break
				default:
					reject ({
						success: false,
						message: lang.request_failure
					})
			}
		})
	}

	const respond = () => {
		res.redirect('/auth/complete');
	}

	const respondError = (error) => {
		const querystring = require('querystring')
		var result = error
		result.redirect = 'reg'
		const query = querystring.stringify(result);

		res.redirect('/error?' + query);
	}

	checkValidation(body)
	.then(create)
	.then(checkData)
	.then(respond)
	.catch(respondError)
}

exports.login = (req, res) => {
	const body = req.body

	const checkValidation = () => {
		return new Promise((resolve, reject) => {
			const id = body.id
			const password = body.password
			const name = body.name
			const idPattern = /^[a-zA-Z0-9]{5,15}$/
			const namePattern = /^[a-zA-Z0-9가-힣]{2,10}$/

			if (idPattern.test(id) === false) {
				reject({
					success: false,
					message: lang.invalid_id
				})
			}
			if (password.length < 4 || password.length > 20) {
				reject({
					success: false,
					message: lang.invalid_password
				})
			}
			
			resolve()
		})
	}

	const login = () => {
		const options = {
			headers: {'content-type': 'application/json'},
			url: 'https://api.zodaland.com/auth/login',
			method: 'POST',
			form: {
				id: body.id,
				password: body.password
			}
		}

		return new Promise((resolve, reject) => {
			request(options, (err, res, body) => {
				if (err) {
					reject({
						success: false,
						message: lang.request_failure
					})
				}
				resolve(body)
			})
		})
	}

	const checkData = (result) => {
		const data = JSON.parse(result)

		return new Promise((resolve, reject) => {
			switch (data.code) {
				case '9999':
					reject({
						success: false,
						message: lang.no_id
					})
					break
				case '9997':
					reject({
						success: false,
						message: lang.not_exist_id
					})
					break
				case '9990':
					reject({
						success: false,
						message: lang.login_failure
					})
					break
				case '0000':
					resolve(data.user)
					break
				default:
					reject({
						success: false,
						message: lang.request_failure
					})
					break
			}
		})
	}

	const createToken = (user) => {
		const p = new Promise((resolve, reject) => {
			const payLoad = {
				id: user[0].id,
				name: user[0].name
			}
			jwt.sign(
				payLoad,
				req.app.get('jwt-secret'),
				{
					expiresIn: '2h',
					issuer: 'zodaland.com',
					subject: 'userinfo'
				}, (err, token) => {
					if (err) {
						reject({
							success: false,
							message: lang.auth_failure
						})
					}
					resolve(token)
				})
		})
		return p
	}

	const respond = (token) => {
		res
		.cookie('token', token, { secure: true, httpOnly: true, expires: new Date(Date.now() + (360000 * 24)) })
		.redirect('/auth/complete')
	}

	const respondError = (error) => {
		const querystring = require('querystring')
		var result = error
		result.redirect = 'login'
		const query = querystring.stringify(result);

		res.redirect('/error?' + query);
	}

	checkValidation(body)
	.then(login)
	.then(checkData)
	.then(createToken)
	.then(respond)
	.catch(respondError)
}
