function saveTransaction() {
    let popup = document.getElementById('popup')

    popup.style.display = 'block'
}

function totalHarga() {
    let harga = document.getElementById('harga').value
    let jumlah = document.getElementById('jumlah').value

    document.getElementById('total').value = harga * jumlah
}