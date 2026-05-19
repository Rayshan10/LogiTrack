<h1>Data Barang</h1>

<a href="{{ route('barang.create') }}">Tambah Barang</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>

    @foreach($barang as $b)
    <tr>
        <td>{{ $b->kode_barang }}</td>
        <td>{{ $b->nama_barang }}</td>
        <td>{{ $b->kategori }}</td>
        <td>{{ $b->jumlah }}</td>
        <td>
            <a href="{{ route('barang.edit', $b->id) }}">Edit</a>

            <form action="{{ route('barang.destroy', $b->id) }}"
                method="POST">
                @csrf
                @method('DELETE')

                <button type="submit">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>