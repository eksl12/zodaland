const db = require('./db')

const Invite = {
	getConnection : () => {
		return new Promise((resolve, reject) => {
			db.getConnection((err, con) => {
				if (err) {
					reject(err)
				}
				resolve(con)
			})
		})
	},

	create : (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "INSERT INTO invite (room_no, invite_user_no, invited_user_no, reg_date) VALUES (?, ?, ?, DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'))"
			con.query(sql, param, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
				resolve(rows)
			})
		})
	},

	findByInviteUser : (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "SELECT no, room_no, invite_user_no, invited_user_no, reg_date FROM invite WHERE invite_user = ?"
			con.query(sql, param, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
				resolve(rows)
			})
		})
	},

	findByInvitedUser : (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "SELECT no, room_no, invite_user_no, invited_user_no, reg_date FROM invite WHERE invited_user = ?"
			con.query(sql, param, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
				resolve(rows)
			})
		})
	},

	delete : (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "DELETE FROM invite WHERE no = ?"
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

module.exports = Invite
