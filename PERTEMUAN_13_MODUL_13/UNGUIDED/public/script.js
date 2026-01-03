const API_URL = 'http://localhost:3000/api/mahasiswa';

// Fungsi untuk menampilkan notifikasi
function showNotification(message, type = 'info') {
    const colors = {
        success: '#10b981',
        error: '#ef4444',
        info: '#3b82f6'
    };
    
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: ${colors[type] || colors.info};
        color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        font-weight: 500;
    `;
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Animasi CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .loading {
        text-align: center;
        padding: 30px;
        color: #666;
    }
`;
document.head.appendChild(style);

// Cek status server saat halaman dimuat
async function checkServer() {
    try {
        const response = await fetch(API_URL);
        if (response.ok) {
            document.getElementById('serverStatus').innerHTML = '🟢 Server Online';
            document.getElementById('serverStatus').style.color = '#10b981';
            showNotification('Server berjalan dengan baik!', 'success');
        }
    } catch (error) {
        document.getElementById('serverStatus').innerHTML = '🔴 Server Offline';
        document.getElementById('serverStatus').style.color = '#ef4444';
        showNotification('Server tidak merespon. Pastikan server Node.js sedang berjalan!', 'error');
    }
}

// Muat data dari API
async function loadData() {
    const tbody = document.getElementById('dataBody');
    tbody.innerHTML = '<tr><td colspan="6" class="loading">Memuat data...</td></tr>';
    
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error('Gagal mengambil data');
        
        const result = await response.json();
        
        if (result.success && result.data.length > 0) {
            tbody.innerHTML = '';
            result.data.forEach(mahasiswa => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${mahasiswa.id}</td>
                    <td>${mahasiswa.nama}</td>
                    <td>${mahasiswa.nim}</td>
                    <td>${mahasiswa.jurusan}</td>
                    <td>${mahasiswa.email}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit" onclick="openEditModal(${mahasiswa.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn-delete" onclick="hapusData(${mahasiswa.id})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
            
            document.getElementById('totalData').textContent = `Total: ${result.data.length} data`;
            showNotification(`Data berhasil dimuat (${result.data.length} data)`, 'success');
        } else {
            tbody.innerHTML = '<tr><td colspan="6" class="loading">Tidak ada data ditemukan</td></tr>';
            document.getElementById('totalData').textContent = 'Total: 0 data';
        }
    } catch (error) {
        tbody.innerHTML = `<tr><td colspan="6" class="loading" style="color:#ef4444">Error: ${error.message}</td></tr>`;
        showNotification('Gagal memuat data dari server', 'error');
    }
}

// Tambah data baru
async function tambahData(event) {
    event.preventDefault();
    
    const data = {
        nama: document.getElementById('nama').value.trim(),
        nim: document.getElementById('nim').value.trim(),
        jurusan: document.getElementById('jurusan').value.trim(),
        email: document.getElementById('email').value.trim()
    };
    
    // Validasi
    if (!data.nama || !data.nim || !data.jurusan || !data.email) {
        showNotification('Semua field harus diisi!', 'error');
        return;
    }
    
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Data berhasil ditambahkan!', 'success');
            resetForm();
            loadData(); // Refresh tabel
        } else {
            showNotification(result.message || 'Gagal menambah data', 'error');
        }
    } catch (error) {
        showNotification('Error: ' + error.message, 'error');
    }
}

// Reset form
function resetForm() {
    document.getElementById('formData').reset();
}

// Buka modal edit
async function openEditModal(id) {
    try {
        const response = await fetch(`${API_URL}/${id}`);
        if (!response.ok) throw new Error('Gagal mengambil data');
        
        const result = await response.json();
        
        if (result.success && result.data.length > 0) {
            const mhs = result.data[0];
            document.getElementById('editId').value = mhs.id;
            document.getElementById('editNama').value = mhs.nama;
            document.getElementById('editNim').value = mhs.nim;
            document.getElementById('editJurusan').value = mhs.jurusan;
            document.getElementById('editEmail').value = mhs.email;
            
            document.getElementById('editModal').style.display = 'flex';
        }
    } catch (error) {
        showNotification('Gagal memuat data untuk edit', 'error');
    }
}

// Update data
async function updateData(event) {
    event.preventDefault();
    
    const id = document.getElementById('editId').value;
    const data = {
        nama: document.getElementById('editNama').value.trim(),
        nim: document.getElementById('editNim').value.trim(),
        jurusan: document.getElementById('editJurusan').value.trim(),
        email: document.getElementById('editEmail').value.trim()
    };
    
    try {
        const response = await fetch(`${API_URL}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Data berhasil diupdate!', 'success');
            closeModal();
            loadData(); // Refresh tabel
        } else {
            showNotification(result.message || 'Gagal mengupdate data', 'error');
        }
    } catch (error) {
        showNotification('Error: ' + error.message, 'error');
    }
}

// Hapus data
async function hapusData(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        return;
    }
    
    try {
        const response = await fetch(`${API_URL}/${id}`, {
            method: 'DELETE'
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Data berhasil dihapus!', 'success');
            loadData(); // Refresh tabel
        } else {
            showNotification(result.message || 'Gagal menghapus data', 'error');
        }
    } catch (error) {
        showNotification('Error: ' + error.message, 'error');
    }
}

// Tutup modal
function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Event listeners saat halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    checkServer();
    loadData();
    
    // Cek server setiap 30 detik
    setInterval(checkServer, 30000);
});