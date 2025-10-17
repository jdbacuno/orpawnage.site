<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pet;
use Illuminate\Support\Str;

class PetListing extends Component
{
    use WithPagination;

    public $species = '';
    public $sex = '';
    public $reproductive_status = '';
    public $color = '';
    public $source = '';
    public $sort_by = '';
    public $search = '';

    protected $queryString = [
        'species' => ['except' => ''],
        'sex' => ['except' => ''],
        'reproductive_status' => ['except' => ''],
        'color' => ['except' => ''],
        'source' => ['except' => ''],
        'sort_by' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    protected $listeners = ['resetFilters' => 'resetFilters'];

    public function resetFilters()
    {
        $this->reset([
            'species',
            'sex',
            'reproductive_status',
            'color',
            'source',
            'sort_by',
            'search'
        ]);
        $this->resetPage();
    }

    public function updatedSearch($value)
    {
        if (!empty($value)) {
            // When searching, reset all filters except sort
            $this->reset([
                'species',
                'sex',
                'reproductive_status',
                'color',
                'source'
            ]);
        }
        $this->resetPage();
    }

    public function updated($property)
    {
        // When any filter changes, clear the search
        if (in_array($property, ['species', 'sex', 'reproductive_status', 'color', 'source'])) {
            $this->search = '';
            $this->resetPage();
        }
    }

    protected function normalizeFilterValue($value)
    {
        return Str::singular(strtolower(trim($value)));
    }

    public function render()
    {
        // Normalize all filter values
        $this->species = $this->normalizeFilterValue($this->species);
        $this->sex = $this->normalizeFilterValue($this->sex);
        $this->reproductive_status = $this->normalizeFilterValue($this->reproductive_status);
        $this->color = $this->normalizeFilterValue($this->color);
        $this->source = $this->normalizeFilterValue($this->source);

        $query = Pet::whereNotIn('id', function ($subQuery) {
            $subQuery->select('pet_id')
                ->from('adoption_applications')
                ->whereNotIn('status', ['rejected']);
        })
            ->whereNull('archived_at'); // Exclude pets with non-null archived_at

        // Apply filters if any are set
        if ($this->species) {
            $query->whereRaw('LOWER(TRIM(species)) = ?', [Str::singular(strtolower($this->species))]);
        }

        if ($this->sex) {
            $query->whereRaw('LOWER(TRIM(sex)) = ?', [Str::singular(strtolower($this->sex))]);
        }

        if ($this->reproductive_status) {
            $query->whereRaw('LOWER(TRIM(reproductive_status)) = ?', [Str::singular(strtolower($this->reproductive_status))]);
        }

        if ($this->color) {
            $query->whereRaw('LOWER(TRIM(color)) = ?', [Str::singular(strtolower($this->color))]);
        }

        if ($this->source) {
            $query->whereRaw('LOWER(TRIM(source)) = ?', [Str::singular(strtolower($this->source))]);
        }

        // Apply search only if we have search terms and no filters are active
        if ($this->search && !$this->hasActiveFilters()) {
            $searchTerms = preg_split('/\s+/', trim($this->search));

            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $term = strtolower(trim($term));
                    $singularTerm = Str::singular($term);

                    $isSexTerm = in_array($term, ['male', 'female']) || in_array($singularTerm, ['male', 'female']);

                    $q->where(function ($subQuery) use ($term, $singularTerm, $isSexTerm) {
                        if ($isSexTerm) {
                            $subQuery->whereRaw('LOWER(TRIM(sex)) = ?', [$term])
                                ->orWhereRaw('LOWER(TRIM(sex)) = ?', [$singularTerm]);
                        } else {
                            $subQuery->whereRaw('LOWER(pet_name) LIKE ?', ['%' . $term . '%'])
                                ->orWhereRaw('LOWER(pet_name) LIKE ?', ['%' . $singularTerm . '%'])
                                ->orWhereRaw('LOWER(species) LIKE ?', ['%' . $term . '%'])
                                ->orWhereRaw('LOWER(species) LIKE ?', ['%' . $singularTerm . '%'])
                                ->orWhereRaw('LOWER(color) LIKE ?', ['%' . $term . '%'])
                                ->orWhereRaw('LOWER(color) LIKE ?', ['%' . $singularTerm . '%'])
                                ->orWhereRaw('LOWER(source) LIKE ?', ['%' . $term . '%'])
                                ->orWhereRaw('LOWER(source) LIKE ?', ['%' . $singularTerm . '%'])
                                ->orWhereRaw('LOWER(reproductive_status) LIKE ?', ['%' . $term . '%'])
                                ->orWhereRaw('LOWER(reproductive_status) LIKE ?', ['%' . $singularTerm . '%'])
                                ->orWhereRaw('LOWER(pet_number) LIKE ?', ['%' . $term . '%']);

                            if ($term === 'cat' || $singularTerm === 'cat') {
                                $subQuery->orWhereRaw('LOWER(TRIM(species)) = ?', ['feline']);
                            }

                            if ($term === 'dog' || $singularTerm === 'dog') {
                                $subQuery->orWhereRaw('LOWER(TRIM(species)) = ?', ['canine']);
                            }

                            if ($term === 'unnamed' || $singularTerm === 'unnamed') {
                                $subQuery->orWhereRaw('LOWER(TRIM(pet_name)) = ?', ['n/a']);
                            }
                        }
                    });
                }
            });
        }

        // Apply sorting
        if ($this->sort_by) {
            switch ($this->sort_by) {
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'youngest':
                    $query->orderByRaw("CASE WHEN age_unit = 'years' THEN age * 12 * 4 WHEN age_unit = 'months' THEN age * 4 WHEN age_unit = 'weeks' THEN age ELSE 0 END ASC");
                    break;
                case 'oldest_age':
                    $query->orderByRaw("CASE WHEN age_unit = 'years' THEN age * 12 * 4 WHEN age_unit = 'months' THEN age * 4 WHEN age_unit = 'weeks' THEN age ELSE 0 END DESC");
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return view('livewire.pet-listing', [
            'pets' => $query->paginate(8)
        ]);
    }

    protected function hasActiveFilters()
    {
        return !empty($this->species) ||
            !empty($this->sex) ||
            !empty($this->reproductive_status) ||
            !empty($this->color) ||
            !empty($this->source);
    }
}
