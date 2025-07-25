<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);
    
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
    
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo_url'] = $logoPath;
        }
    
        Department::create($data);
    
        return redirect()->route('admin.departments.index')->with('success', 'Department berhasil ditambahkan.');
    }

    public function edit(Request $request, Department $department)
    {
        
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);
    
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
    
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($department->logo_url && Storage::disk('public')->exists($department->logo_url)) {
                Storage::disk('public')->delete($department->logo_url);
            }
    
            // Simpan logo baru
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo_url'] = $logoPath;
        }
    
        $department->update($data);
        return redirect()->route('admin.departments.index')->with('success', 'Department updated!');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted!');
    }
    public function refresh()
    {
        try {
            $response = Http::get('https://accounts.keloola.xyz/api/applications');
    
            if ($response->successful()) {
                $data = $response->json('data'); // ambil hanya array di dalam "data"
    
                if (!is_array($data)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Format data tidak sesuai (bukan array).',
                    ]);
                }
    
                foreach ($data as $item) {
                    if (!isset($item['id'], $item['name'])) {
                        continue;
                    }
    
                    Department::updateOrCreate(
                        ['external_id' => $item['id']],
                        [
                            'name' => $item['name'],
                            'slug' => \Str::slug($item['name']),
                        ]
                    );
                }
    
                return response()->json([
                    'success' => true,
                    'message' => 'Data department berhasil diperbarui!',
                ]);
            }
    
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari API. Status: ' . $response->status(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
    
    
    }