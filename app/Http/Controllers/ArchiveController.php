<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\AdoptionApplication;
use App\Models\SurrenderApplication;
use App\Models\MissingPetReport;
use App\Models\AbusedPetReport;
use App\Models\AnimalAbuseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function destroy($type, $id)
    {
        $item = match ($type) {
            'pets' => Pet::findOrFail($id),
            'adoption' => AdoptionApplication::findOrFail($id),
            'missing' => MissingPetReport::findOrFail($id),
            'abused' => AnimalAbuseReport::findOrFail($id),
            default => null,
        };

        if (!$item) {
            return back()->with('error', 'Invalid archive type');
        }

        // Handle deletion based on type
        switch ($type) {
            case 'pets':
                // Delete pet image if exists
                if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                    Storage::disk('public')->delete($item->image_path);
                }
                $item->delete();
                break;

            case 'adoption':
                // Delete valid ID file if exists
                if ($item->valid_id && Storage::disk('public')->exists($item->valid_id)) {
                    Storage::disk('public')->delete($item->valid_id);
                }
                $item->delete();
                break;

            case 'missing':
                // Delete files associated with missing pet report
                if ($item->valid_id_path && Storage::disk('public')->exists($item->valid_id_path)) {
                    Storage::disk('public')->delete($item->valid_id_path);
                }
                if ($item->pet_photos) {
                    foreach (json_decode($item->pet_photos) as $photo) {
                        if (Storage::disk('public')->exists($photo)) {
                            Storage::disk('public')->delete($photo);
                        }
                    }
                }
                if ($item->location_photos) {
                    foreach (json_decode($item->location_photos) as $photo) {
                        if (Storage::disk('public')->exists($photo)) {
                            Storage::disk('public')->delete($photo);
                        }
                    }
                }
                $item->delete();
                break;

            case 'abused':
                // Delete files associated with abuse report
                if ($item->valid_id_path && Storage::disk('public')->exists($item->valid_id_path)) {
                    Storage::disk('public')->delete($item->valid_id_path);
                }
                if ($item->incident_photos) {
                    foreach (json_decode($item->incident_photos) as $photo) {
                        if (Storage::disk('public')->exists($photo)) {
                            Storage::disk('public')->delete($photo);
                        }
                    }
                }
                $item->delete();
                break;
        }

        return back()->with('success', 'Item has been permanently deleted.');
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
