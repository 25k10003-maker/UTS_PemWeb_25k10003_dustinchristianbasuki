<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function __construct(private ApiClient $api) {}

    /** READ - daftar barang (admin & operator) */
    public function index(Request $request): View
    {
        $res = $this->api->get('barang', array_filter(['search' => $request->query('search')]));

        return view('barang.index', [
            'barang' => $res->json('data') ?? [],
            'search' => $request->query('search'),
            'apiError' => $res->failed() ? $res->json('message') : null,
        ]);
    }

    /** CREATE - form (admin) */
    public function create(): View
    {
        return view('barang.form', ['barang' => null]);
    }

    /** CREATE - simpan (admin) */
    public function store(Request $request): RedirectResponse
    {
        $res = $this->api->post('barang', $this->formData($request));

        return $this->respond($res, 'barang.index');
    }

    /** UPDATE - form (admin) */
    public function edit(int $id): View|RedirectResponse
    {
        $res = $this->api->get("barang/{$id}");

        if ($res->failed()) {
            return redirect()->route('barang.index')->with('error', $res->json('message') ?? 'Barang tidak ditemukan.');
        }

        return view('barang.form', ['barang' => $res->json('data')]);
    }

    /** UPDATE - simpan (admin) */
    public function update(Request $request, int $id): RedirectResponse
    {
        $res = $this->api->put("barang/{$id}", $this->formData($request));

        return $this->respond($res, 'barang.index');
    }

    /** DELETE (admin) */
    public function destroy(int $id): RedirectResponse
    {
        $res = $this->api->delete("barang/{$id}");

        return $this->respond($res, 'barang.index');
    }

    /** UPDATE QTY via penjualan (operator / kasir) */
    public function jual(Request $request, int $id): RedirectResponse
    {
        $request->validate(['jumlah' => ['required', 'integer', 'min:1']]);

        $res = $this->api->patch("barang/{$id}/jual", ['jumlah' => (int) $request->input('jumlah')]);
        //dd("RESPONSE SERVER:", $res->json());
        return $this->respond($res, 'barang.index');
    }

    private function formData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'qty' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);
    }

    private function respond(Response $res, string $successRoute): RedirectResponse
    {
        if ($res->failed()) {
            return back()->withInput()
                ->withErrors($res->json('errors') ?? [])
                ->with('error', $res->json('message') ?? 'Terjadi kesalahan pada API.');
        }

        return redirect()->route($successRoute)->with('success', $res->json('message'));
    }
}
