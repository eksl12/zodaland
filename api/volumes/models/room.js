const db = require('./db')

const Room = {
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

	create : (con) => {
		return new Promise((resolve, reject) => {
			var sql = "INSERT INTO room (reg_date) VALUES (DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'))";
			con.query(sql, (err, rows) => {
				con.release()
				if (err) {
					reject(err)
				}
				resolve(rows)
			}
		})
	},

	find : (con, param) => {
		return new Promise((resolve, reject) => {
			var sql = "SELECT no, reg_date FROM room WHERE no = ?";

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
			var sql = "DELETE FROM room WHERE no = ?";

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

module.exports = Room
