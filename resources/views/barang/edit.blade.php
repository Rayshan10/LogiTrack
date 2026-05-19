<h1>Edit Barang</h1>

<form action="{{ route('barang.update', $barang->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text"
           name="kode_barang"
           value="{{ $barang->kode_barang }}">
    <br><br>

    <input type="text"
           name="nama_barang"
           value="{{ $barang->nama_barang }}">
    <br><br>

    <input type="text"
           name="kategori"
           value="{{ $barang->kategori }}">
    <br><br>

    <input type="number"
           name="jumlah"
           value="{{ $barang->jumlah }}">
    <br><br>

    <textarea name="deskripsi">{{ $barang->deskripsi }}</textarea>
    <br><br>

    <button type="submit">Update</button>
</form>