<h1>Tambah Barang</h1>

<form action="{{ route('barang.store') }}" method="POST">
    @csrf

    <input type="text" name="kode_barang" placeholder="Kode Barang">
    <br><br>

    <input type="text" name="nama_barang" placeholder="Nama Barang">
    <br><br>

    <input type="text" name="kategori" placeholder="Kategori">
    <br><br>

    <input type="number" name="jumlah" placeholder="Jumlah">
    <br><br>

    <textarea name="deskripsi" placeholder="Deskripsi"></textarea>
    <br><br>

    <button type="submit">Simpan</button>
</form>