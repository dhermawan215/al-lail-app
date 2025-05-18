<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $masjidName = $user->userToMasjid()->first();
        return view('dashboard', ['title' => 'Dashboard', 'userName' => $user->name, 'masjid' => $masjidName->name]);
    }

    public function graphicReportDashboard()
    {
        $user = Auth::user();

        $report = Transaction::selectRaw('DATE(transaction_date) as date, category_id, SUM(amount) as total')
            ->where('masjid_id', $user->masjid_id)
            ->groupByRaw('DATE(transaction_date), category_id')
            ->orderBy('date')
            ->get();

        $labels = [];
        $pemasukan = [];
        $pengeluaran = [];

        foreach ($report as $row) {
            $date = $row->date;

            // Tambahkan tanggal ke labels jika belum ada
            if (!in_array($date, $labels)) {
                $labels[] = $date;
            }
        }

        // Inisialisasi array amount untuk setiap tanggal
        foreach ($labels as $date) {
            $pemasukan[$date] = 0;
            $pengeluaran[$date] = 0;
        }

        // Masukkan nilai amount ke kategori masing-masing
        foreach ($report as $row) {
            $date = $row->date;
            if ($row->category_id == 1) {
                $pengeluaran[$date] = $row->total;
            } elseif ($row->category_id == 2) {
                $pemasukan[$date] = $row->total;
            }
        }

        // Format data untuk chart
        $chartData = [
            'labels' => $labels,
            'pemasukan' => array_values($pemasukan),
            'pengeluaran' => array_values($pengeluaran),
        ];


        return \response()->json($chartData, 200);
    }
}
