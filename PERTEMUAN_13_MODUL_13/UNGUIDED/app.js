const express = require('express');
const mahasiswa = require('./crud');
const path = require('path');

const app = express();
const PORT = 3000;

// ========== MIDDLEWARE ==========
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// ========== ROUTES API ==========

// GET: /api/mahasiswa - Ambil semua data
app.get('/api/mahasiswa', (req, res) => {
    mahasiswa.findAll((err, data) => {
        if (err) {
            return res.status(500).json({
                success: false,
                message: 'Gagal mengambil data',
                error: err.message
            });
        }
        res.json({
            success: true,
            count: data.length,
            data: data
        });
    });
});

// POST: /api/mahasiswa - Tambah data baru
app.post('/api/mahasiswa', (req, res) => {
    const { nama, nim, jurusan, email } = req.body;
    
    // Validasi input
    if (!nama || !nim || !jurusan || !email) {
        return res.status(400).json({
            success: false,
            message: 'Semua field harus diisi!'
        });
    }

    const data = { nama, nim, jurusan, email };
    
    mahasiswa.create(data, (err, result) => {
        if (err) {
            return res.status(500).json({
                success: false,
                message: 'Gagal menambah data',
                error: err.message
            });
        }
        res.status(201).json({
            success: true,
            message: 'Data berhasil ditambahkan',
            id: result.insertId
        });
    });
});

// PUT: /api/mahasiswa/:id - Update data
app.put('/api/mahasiswa/:id', (req, res) => {
    const id = req.params.id;
    const { nama, nim, jurusan, email } = req.body;
    
    if (!nama || !nim || !jurusan || !email) {
        return res.status(400).json({
            success: false,
            message: 'Semua field harus diisi!'
        });
    }

    const data = { nama, nim, jurusan, email };
    
    mahasiswa.update(id, data, (err, result) => {
        if (err) {
            return res.status(500).json({
                success: false,
                message: 'Gagal mengupdate data',
                error: err.message
            });
        }
        res.json({
            success: true,
            message: 'Data berhasil diupdate',
            affectedRows: result.affectedRows
        });
    });
});

// DELETE: /api/mahasiswa/:id - Hapus data
app.delete('/api/mahasiswa/:id', (req, res) => {
    const id = req.params.id;
    
    mahasiswa.delete(id, (err, result) => {
        if (err) {
            return res.status(500).json({
                success: false,
                message: 'Gagal menghapus data',
                error: err.message
            });
        }
        res.json({
            success: true,
            message: 'Data berhasil dihapus',
            affectedRows: result.affectedRows
        });
    });
});

// ========== ROUTES HALAMAN ==========
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// ========== START SERVER ==========
app.listen(PORT, () => {
    console.log('='.repeat(50));
    console.log('🚀 SERVER NODE.JS BERJALAN');
    console.log('='.repeat(50));
    console.log(`📡 Port: http://localhost:${PORT}`);
    console.log(`📁 Public: http://localhost:${PORT}/public`);
    console.log(`📊 API: http://localhost:${PORT}/api/mahasiswa`);
    console.log('='.repeat(50));
    console.log('🎯 Tekan Ctrl+C untuk stop server');
});