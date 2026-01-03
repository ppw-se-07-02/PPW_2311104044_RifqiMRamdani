const connection = require('./db');

const mahasiswaModel = {
    // CREATE - Tambah data baru
    create: (data, callback) => {
        const sql = "INSERT INTO mahasiswa SET ?";
        connection.query(sql, data, (err, result) => {
            callback(err, result);
        });
    },

    // READ ALL - Ambil semua data
    findAll: (callback) => {
        const sql = "SELECT * FROM mahasiswa ORDER BY id DESC";
        connection.query(sql, (err, results) => {
            callback(err, results);
        });
    },

    // READ ONE - Ambil data by ID
    findById: (id, callback) => {
        const sql = "SELECT * FROM mahasiswa WHERE id = ?";
        connection.query(sql, [id], (err, result) => {
            callback(err, result);
        });
    },

    // UPDATE - Update data by ID
    update: (id, data, callback) => {
        const sql = "UPDATE mahasiswa SET ? WHERE id = ?";
        connection.query(sql, [data, id], (err, result) => {
            callback(err, result);
        });
    },

    // DELETE - Hapus data by ID
    delete: (id, callback) => {
        const sql = "DELETE FROM mahasiswa WHERE id = ?";
        connection.query(sql, [id], (err, result) => {
            callback(err, result);
        });
    }
};

module.exports = mahasiswaModel;