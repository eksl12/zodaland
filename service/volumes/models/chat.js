const db = require('./db');


function getAllChats(callback) {
    db.query('SELECT * FROM chats ORDER BY no DESC', (err, rows, fields) => {
        if (err) throw err;
        callback(rows);
    });
}


module.exports = {
	getAllChats
}
