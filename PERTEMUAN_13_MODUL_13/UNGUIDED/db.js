const mysql = require('mysql');

// Koneksi ke database MySQL (XAMPP default)
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',  // Password kosong untuk XAMPP default
    database: 'akademik'  // Sesuaikan dengan nama database Anda
});

// Tes koneksi
connection.connect((err) => {
    if (err) {
        console.error('❌ ERROR Koneksi Database:', err.message);
        console.log('Pastikan:');
        console.log('1. XAMPP MySQL sedang running');
        console.log('2. Database "akademik" sudah dibuat');
        console.log('3. Username: root, Password: (kosong)');
        return;
    }
    console.log('✅ SUCCESS: Terhubung ke MySQL Database!');
    console.log('📊 Database:', connection.config.database);
    console.log('🔗 Connection ID:', connection.threadId);
});

module.exports = connection;