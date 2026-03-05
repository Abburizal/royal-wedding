<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Vendor;
use App\Models\VendorAssignment;
use App\Models\Wedding;
use Illuminate\Http\Request;

class VendorAssignmentController extends Controller
{
    public function store(Request $request, Wedding $wedding)
    {
        $data = $request->validate([
            'vendor_id'    => 'required|exists:vendors,id',
            'category'     => 'required|string|max:100',
            'agreed_price' => 'required|numeric|min:0',
            'status'       => 'required|in:pending,confirmed,completed,cancelled',
            'notes'        => 'nullable|string|max:500',
        ]);

        // Cegah duplikat vendor di wedding yang sama
        $exists = $wedding->vendorAssignments()
            ->where('vendor_id', $data['vendor_id'])
            ->where('category', $data['category'])
            ->exists();

        if ($exists) {
            return back()->with('vendor_error', 'Vendor ini sudah di-assign dengan kategori yang sama.');
        }

        $data['wedding_id'] = $wedding->id;
        $assignment = VendorAssignment::create($data);

        ActivityLog::record(
            'created',
            'Assign vendor ' . $assignment->vendor->name . ' ke wedding ' . $wedding->couple_name,
            $wedding
        );

        return back()->with('vendor_success', 'Vendor berhasil di-assign.');
    }

    public function update(Request $request, Wedding $wedding, VendorAssignment $assignment)
    {
        abort_unless($assignment->wedding_id === $wedding->id, 403);

        $data = $request->validate([
            'agreed_price' => 'required|numeric|min:0',
            'status'       => 'required|in:pending,confirmed,completed,cancelled',
            'notes'        => 'nullable|string|max:500',
        ]);

        $assignment->update($data);
        return back()->with('vendor_success', 'Assignment diperbarui.');
    }

    public function destroy(Wedding $wedding, VendorAssignment $assignment)
    {
        abort_unless($assignment->wedding_id === $wedding->id, 403);

        $vendorName = $assignment->vendor->name;
        $assignment->delete();

        ActivityLog::record('deleted', 'Hapus vendor ' . $vendorName . ' dari wedding ' . $wedding->couple_name, $wedding);

        return back()->with('vendor_success', 'Vendor berhasil dihapus dari wedding.');
    }
}
