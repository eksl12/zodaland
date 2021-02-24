const db = require('./db')

const RoomUser = {
	getConnection: () => {
		return new Promise((resolve, reject) => {
			db.getConnection((err, con) => {
				if (err) {
					reject(err)
				}
				resolve(con)
			})
		})
	},

	create: (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "INSERT INTO room_user (room_no, user_no, name, join_date) VALUES (?, ?, ?, DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'))"
			con.query(sql, param, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
					resolve(rows)
			})
		})
	},

	find: (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "SELECT no, room_no, user_no, name, join_date, exit_date FROM room_user WHERE user_no = ?"
			con.query(sql, param, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
				resolve(rows)
			})
		})
	},

	delete: (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "DELETE FROM room_user WHERE no = ?"
			con.query(sql, param, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
				resolve(rows)
			})
		})
	},

	updateName: (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "UPDATE room_user SET name = ? WHERE user_no = ?"
			con.query(sql, param, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
				resolve(rows)
			})
		})
	}

	updateExitDate: (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "UPDATE room_user SET exit_date = ? WHERE user_no = ?"
			con.query(sql, param, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
				resolve(rows)
			})
		})
	}
}

module.exports = RoomUser
