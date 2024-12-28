// Ambil elemen modal
var modal = document.getElementById("loginModal");

// Ambil tombol untuk membuka modal
var btn = document.getElementById("openModalBtn");

// Ambil tombol untuk menutup modal
var closeBtn = document.getElementsByClassName("close")[0];

// Saat tombol "Login" diklik, tampilkan modal
btn.onclick = function() {
    modal.style.display = "block";
  }
  
  // Saat tombol "X" di modal diklik, tutup modal
  closeBtn.onclick = function() {
    closeModal();
  }
  
  // Saat pengguna mengklik di luar modal, tutup modal
  window.onclick = function(event) {
    if (event.target == modal) {
      closeModal();
    }
  }
  
  // Fungsi untuk menutup modal
  function closeModal() {
    modal.style.display = "none";
  }