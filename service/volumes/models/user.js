/******************************************






******************************************/

const db = require('./db');

const User = {
	

	getConnection : () => {
		return new Promise( (resolve, reject) => {
			db.getConnection((err, con) => {
				if (err) {
					reject(err);
				}
				resolve(con);
			});
		});
	},

	create : (con, param) => {
		return new Promise( (resolve, reject) => {
			var sql = "INSERT INTO user (id, password, name, reg_date) VALUES (?, ?, ?, DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'))";
			con.query(sql, param, (err, rows) => {
				con.release();
				if (err) {
					reject(err);
				}
				resolve(rows);
			});
		});
	},

	verify : (con, param) => {
		return new Promise( (resolve, reject) => {
			var sql = "SELECT id, name FROM user WHERE id = ? AND password = ?";
			
			con.query(sql, param, (err, rows) => {
				con.release();
				if (err) {
					reject(err);
				}
				resolve(rows);
			});
		});
	},

	find : (con, param) => {
		return new Promise( (resolve, reject) => {
			var sql = "SELECT count(no) as count FROM user WHERE id = ?";
			
			con.query(sql, param, (err, rows) => {
				if (err) {
					reject(err);
				}
				resolve(rows);
			});
		});
	}
}

module.exports = User
