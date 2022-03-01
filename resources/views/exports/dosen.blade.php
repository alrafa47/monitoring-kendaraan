<table>
    <tr>
        <td>NIP</td>
        <td>Nama</td>
        <td>Kode Prodi</td>
        <td>Email</td>
        <td>Telp</td>
    </tr>
    @foreach ($dosens as $dosen)
        <tr>
            <th>{{ $dosen->nip }}</th>
            <th>{{ $dosen->user->name }}</th>
            <th>{{ $dosen->prodi->kode_prodi }}</th>
            <th>{{ $dosen->user->email }}</th>
            <th>{{ $dosen->telp }}</th>
        </tr>
    @endforeach
</table>
