@extends('layouts.dashboard')
@section('content')

<style>
    .content-wrapper { max-width: 1000px; margin: 0 auto; width: 100%; }
    .friend-page { display: flex; min-height: 100vh; background: #FFF8F7; }
    .friend-main { flex: 1; min-width: 0; padding: 32px 40px; }
    .friend-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; width: 100%; }
    .friend-header h2 { font-weight: 700; color: #1F1F1F; margin-bottom: 2px; }
    .friend-header p { color: #FF9D9D; margin: 0; }
    .btn-add-friend { background: #C55F4E; color: #fff; border: none; border-radius: 10px; padding: 10px 18px; font-weight: 600; text-decoration: none; margin-left: auto; }
    .btn-add-friend:hover { background: #a94a3b; color: #fff; }
    .friend-table-wrapper { background: #FFE6E3; border-radius: 18px; padding: 16px; }
    .friend-table-wrapper table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .friend-table-wrapper thead th { text-align: left; font-size: 12px; font-weight: 700; color: #EA8A8A; text-transform: uppercase; padding: 0 16px 6px; }
    .friend-table-wrapper tbody tr { background: #fff; }
    .friend-table-wrapper tbody td { padding: 14px 16px; color: #333; vertical-align: middle; }
    .friend-table-wrapper tbody tr td:first-child { border-radius: 12px 0 0 12px; }
    .friend-table-wrapper tbody tr td:last-child { border-radius: 0 12px 12px 0; }
    .friend-avatar { width: 34px; height: 34px; border-radius: 50%; margin-right: 10px; vertical-align: middle; }
    .friend-note { display: block; font-size: 12px; color: #999; }
    .friend-action-btn { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; border: none; color: #fff; font-size: 13px; text-decoration: none; }
    .friend-action-btn.edit { background: #FFC6C6; }
    .friend-action-btn.delete { background: #FFC6C6; }
</style>

<div class="content-wrapper">
    <div class="friend-header">
        <a href="{{ route('friends.create') }}" class="btn-add-friend">+ Tambah Teman</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 16px; color: #155724; background-color: #d4edda; border-color: #c3e6cb; padding: 12px; border-radius: 8px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="friend-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. Telepon</th>
                    <th>Tanggal Lahir</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($friends as $friend)
                    <tr>
                        <td>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($friend->name) }}&background=fff&color=C55F4E" class="friend-avatar">
                            <strong>{{ $friend->name }}</strong>
                        </td>
                        <td>{{ $friend->phone ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($friend->birth_date)->format('d-m-Y') }}</td>
                        <td>{{ $friend->notes ?? '-' }}</td>
                        <td>
                            <a href="{{ route('friends.edit', $friend->id) }}" class="friend-action-btn edit">✎</a>
                            <form action="{{ route('friends.destroy', $friend->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="friend-action-btn delete">✕</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:24px;">Belum ada data teman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection