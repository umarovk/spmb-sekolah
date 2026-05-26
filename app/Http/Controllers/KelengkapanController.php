<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Services\KelengkapanDataService;
use Illuminate\Http\Request;

class KelengkapanController extends Controller
{
    public function index(Request $request, KelengkapanDataService $kelengkapan)
    {
        $required = $kelengkapan->requiredFields();

        $q      = trim((string) $request->input('q', ''));
        $filter = $request->input('filter', 'all'); // all | incomplete | complete

        $query = Siswa::query()->orderBy('namasiswa');
        if ($q !== '') {
            $like = '%' . str_replace(['%', '_'], ['\%', '\_'], $q) . '%';
            $query->where(function ($w) use ($like) {
                $w->where('namasiswa', 'like', $like)
                  ->orWhere('nisn', 'like', $like)
                  ->orWhere('nis', 'like', $like)
                  ->orWhere('nik', 'like', $like);
            });
        }

        // Hitung kelengkapan per siswa
        $rows = $query->get()->map(function (Siswa $s) use ($kelengkapan, $required) {
            $score = $kelengkapan->score($s, $required);
            return [
                'id'         => $s->id,
                'nama'       => $s->namasiswa,
                'jurusan'    => $s->jurusan,
                'kelas'      => null,
                'sekolah'    => $s->sekolah_asal,
                'percentage' => $score['percentage'],
                'filled'     => $score['filled'],
                'total'      => $score['total'],
                'missing'    => $score['missing'],
            ];
        });

        if ($filter === 'incomplete') {
            $rows = $rows->where('percentage', '<', 100)->values();
        } elseif ($filter === 'complete') {
            $rows = $rows->where('percentage', '>=', 100)->values();
        }

        // Ringkasan
        $total           = $rows->count();
        $totalAll        = Siswa::count();
        $avgPercentage   = $total ? (int) round($rows->avg('percentage')) : 0;
        $countComplete   = $rows->where('percentage', '>=', 100)->count();
        $countIncomplete = $total - $countComplete;

        // Pagination manual (Collection -> paginator)
        $perPage = 25;
        $page    = max(1, (int) $request->input('page', 1));
        $paged   = $rows->slice(($page - 1) * $perPage, $perPage)->values();

        return view('kelengkapan.index', [
            'rows'            => $paged,
            'page'            => $page,
            'perPage'         => $perPage,
            'total'           => $total,
            'totalAll'        => $totalAll,
            'avgPercentage'   => $avgPercentage,
            'countComplete'   => $countComplete,
            'countIncomplete' => $countIncomplete,
            'requiredFields'  => $required,
            'fieldLabels'     => KelengkapanDataService::FIELD_LABELS,
            'q'               => $q,
            'filter'          => $filter,
        ]);
    }
}
