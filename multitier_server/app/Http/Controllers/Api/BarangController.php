<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /** GET /api/barang  (admin & operator) */
    public function index(Request $request): JsonResponse
    {
        $query = Barang::query()->orderBy('id');

        if ($search = $request->query('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        return response()->json(['success' => true, 'data' => $query->get()]);
    }

    /** GET /api/barang/{barang}  (admin & operator) */
    public function show(Barang $barang): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $barang]);
    }

    /** POST /api/barang  (admin) */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'qty' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $barang = Barang::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan.',
            'data' => $barang,
        ], 201);
    }

    /** PUT /api/barang/{barang}  (admin) */
    public function update(Request $request, Barang $barang): JsonResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'qty' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $barang->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diperbarui.',
            'data' => $barang->fresh(),
        ]);
    }

    /** DELETE /api/barang/{barang}  (admin) */
    public function destroy(Barang $barang): JsonResponse
    {
        $barang->delete();

        return response()->json(['success' => true, 'message' => 'Barang berhasil dihapus.']);
    }

    /**
     * PATCH /api/barang/{barang}/jual  (operator / kasir)
     * Operator hanya dapat mengubah QTY dengan cara menjual barang (QTY berkurang).
     */
    public function jual(Request $request, Barang $barang): JsonResponse
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $result = DB::transaction(function () use ($barang, $data) {
            $item = Barang::whereKey($barang->id)->lockForUpdate()->first();

            if ($item->qty < $data['jumlah']) {
                return null;
            }

            $item->decrement('qty', $data['jumlah']);

            return $item->fresh();
        });

        if (! $result) {
            return response()->json([
                'success' => false,
                'error' => 'stok_kurang',
                'message' => "Stok {$barang->nama} tidak cukup (sisa {$barang->fresh()->qty}).",
            ], 422);
        }

        $total = $data['jumlah'] * (float) $result->price;

        return response()->json([
            'success' => true,
            'message' => "Terjual {$data['jumlah']} x {$result->nama}. Total: Rp ".number_format($total, 0, ',', '.'),
            'data' => [
                'barang' => $result,
                'jumlah' => $data['jumlah'],
                'total' => $total,
            ],
        ]);
    }
}
