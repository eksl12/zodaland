exports.error = (req, res) => {
	data = req.query
console.log(data);
	if (data.code === undefined || data.message === undefined || data.redirect === undefined) {
		res.status(409).send('error')
		return
	}
	res.render('error', req.query)
}
