<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\AdoptionApplication;
use App\Models\SurrenderApplication;
use App\Models\MissingPetReport;
use App\Models\AbusedPetReport;
use App\Models\AnimalAbuseReport;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        $type = request('type', 'pets');
        $perPage = 9;

        $items = match ($type) {
            'pets' => Pet::whereNotNull('archived_at')
                ->orderBy('archived_at', 'desc')
                ->paginate($perPage),
            'adoption' => AdoptionApplication::where('status', 'archived')
                ->orderBy('updated_at', 'desc')
                ->paginate($perPage),
            // 'surrender' => SurrenderApplication::where('status', 'archived')
            //     ->orderBy('updated_at', 'desc')
            //     ->paginate($perPage),
            'missing' => MissingPetReport::where('status', 'archived')
                ->orderBy('updated_at', 'desc')
                ->paginate($perPage),
            'abused' => AnimalAbuseReport::where('status', 'archived')
                ->orderBy('updated_at', 'desc')
                ->paginate($perPage),
            default => null,
        };

        return view('admin.archives', [
            'items' => $items,
            'type' => $type
        ]);
    }

    public function restore($type, $id)
    {
        $item = match ($type) {
            'pets' => Pet::findOrFail($id),
            'adoption' => AdoptionApplication::findOrFail($id),
            // 'surrender' => SurrenderApplication::findOrFail($id),
            'missing' => MissingPetReport::findOrFail($id),
            'abused' => AnimalAbuseReport::findOrFail($id),
            default => null,
        };

        if (!$item) {
            return back()->with('error', 'Invalid archive type');
        }

        if ($type === 'pets') {
            $item->update(
                [
                    'archived_at' => null,
                    'archive_reason' => null,
                    'archive_notes' => null
                ]
            );
        } else {
            $item->update(['status' => $item->previous_status ?? $this->getDefaultStatus($type)]);
        }

        return back()->with('success', 'Item has been unarchived successfully.');
    }

    protected function getDefaultStatus($type)
    {
        return match ($type) {
            'adoption', 'surrender' => 'rejected',
            'missing', 'abused' => 'acknowledged',
            default => null,
        };
    }
}
