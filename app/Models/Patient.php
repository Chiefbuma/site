<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'patient';
    protected $primaryKey = 'patient_id';

    protected $fillable = [
        'firstname',
        'lastname',
        'dob',
        'age',
        'gender',
        'location',
        'phone_no',
        'email',
        'patient_no',
        'patient_status',
        'cohort_id',
        'branch_id',
        'scheme_id',
        'route_id',
    ];

    protected $casts = [
        'dob' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Accessors
    public function getFullNameAttribute()
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    public function getAgeAttribute()
    {
        return $this->dob ? Carbon::parse($this->dob)->age : null;
    }

    public function getIsActiveAttribute()
    {
        return is_null($this->deleted_at) && $this->patient_status === 'active';
    }

    // Relationships
    public function cohort()
    {
        return $this->belongsTo(Cohort::class, 'cohort_id', 'cohort_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id', 'scheme_id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    public function diagnoses()
    {
        return $this->belongsToMany(Diagnosis::class, 'patient_diagnosis', 'patient_id', 'diagnosis_id')
                    ->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'patient_status', 'status_id');
    }

    public function calls()
    {
        return $this->hasMany(Call::class, 'patient_id', 'patient_id');
    }

    // Add this accessor to get the last interaction date
    public function getLastInteractionAttribute()
    {
        $lastCall = $this->calls()->latest('call_date')->first();
        return $lastCall ? $lastCall->call_date : null;
    }

    // Add this accessor to get the days since last interaction
    public function getDaysSinceLastInteractionAttribute()
    {
        if (!$this->last_interaction) {
            return null;
        }
    
        return Carbon::parse($this->last_interaction)->diffInDays(Carbon::now(), false);
    }

    public function diagnosesWithTrashed()
    {
        return $this->belongsToMany(Diagnosis::class, 'patient_diagnosis', 'patient_id', 'diagnosis_id')
                    ->withTrashed();
    }

    public function trashedDiagnoses()
    {
        return $this->belongsToMany(Diagnosis::class, 'patient_diagnosis', 'patient_id', 'diagnosis_id')
                    ->onlyTrashed();
    }

    // Cache methods
    protected static function cacheKey($type): string
    {
        return "patients_count_{$type}";
    }

    public static function cachedActiveCount(): int
    {
        return Cache::remember(
            static::cacheKey('active'),
            now()->addMinutes(30),
            fn() => static::withoutGlobalScopes()->whereNull('deleted_at')->count()
        );
    }

    public static function cachedTrashedCount(): int
    {
        return Cache::remember(
            static::cacheKey('trashed'),
            now()->addMinutes(30),
            fn() => static::withoutGlobalScopes()->onlyTrashed()->count()
        );
    }

    public static function cachedTotalCount(): int
    {
        return Cache::remember(
            static::cacheKey('total'),
            now()->addMinutes(30),
            fn() => static::withoutGlobalScopes()->withTrashed()->count()
        );
    }

    public static function clearCountCache(): void
    {
        Cache::forget(static::cacheKey('active'));
        Cache::forget(static::cacheKey('trashed'));
        Cache::forget(static::cacheKey('total'));
    }

    // Model events
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('not_deleted', function ($builder) {
            $builder->whereNull('deleted_at');
        });

        static::restoring(function () {
            static::clearCountCache();
        });

        static::deleting(function () {
            static::clearCountCache();
        });

        static::created(function () {
            static::clearCountCache();
        });

        static::updated(function ($patient) {
            if ($patient->isDirty(['deleted_at'])) {
                static::clearCountCache();
            }
        });

        static::saved(function () {
            static::clearCountCache();
        });

        static::creating(function ($model) {
            if (self::where('patient_no', $model->patient_no)->exists()) {
                throw new \Exception('Patient number already exists');
            }
            
            if (self::where('phone_no', $model->phone_no)->exists()) {
                throw new \Exception('Phone number already exists');
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('patient_no') && self::where('patient_no', $model->patient_no)->where('patient_id', '!=', $model->patient_id)->exists()) {
                throw new \Exception('Patient number already exists');
            }
            
            if ($model->isDirty('phone_no') && self::where('phone_no', $model->phone_no)->where('patient_id', '!=', $model->patient_id)->exists()) {
                throw new \Exception('Phone number already exists');
            }
        });
    }
}