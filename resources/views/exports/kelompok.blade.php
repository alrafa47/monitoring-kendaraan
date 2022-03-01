<h1>Laporan Penggunaan Kendaraan</h1>
<table class="table">
    <thead>
        <tr>
            <th>Nama Driver</th>
            <th>Merk Mobil (warna)</th>
            <th>Acc kabag Kepegawaian</th>
            <th>Acc kabag Umum</th>
            <th>tgl Keluar</th>
            <th>tgl Masuk</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($rentals as $rental)
            <tr>
                <td>{{ $rental->employee->nama }}</td>
                <td>{{ "{$rental->transport->merk} ({$rental->transport->warna})" }}</td>
                <td>
                    {{ $rental->acc_divisi_kepegawaian ? "disetujui pada {$rental->acc_divisi_kepegawaian}" : 'Belum Disetujui' }}
                </td>
                <td>
                    {{ $rental->acc_divisi_umum ? "disetujui pada {$rental->acc_divisi_umum}" : 'Belum Disetujui' }}
                </td>
                <td>{{ $rental->tgl_keluar ?? '-' }}</td>
                <td>{{ $rental->tgl_kembali ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    Tidak ada Data
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
