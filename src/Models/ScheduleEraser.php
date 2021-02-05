<?php namespace Tipoff\Scheduling\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleEraser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_at',
        'end_at',
        'room_id',
        'creator_id',
    ];

    /**
     * Json objects.
     *
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->creator_id = auth()->id();
            }
        });
    }

    /**
     * Scope a query to apply filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $filters array
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters)
    {
        if (empty($filters)) {
            return $query;
        }

        foreach ($filters as $filterKey => $filterValue) {
            switch ($filterKey) {
                case 'start_at':
                case 'end_at':
                case 'room_id':
                case 'creator_id':
                    $query->where($filterKey, $filterValue);

                    break;
            }
        }

        return $query;
    }

    public function creator()
    {
        return $this->belongsTo(config('tipoff.model_class.user'), 'creator_id');
    }

    public function room()
    {
        return $this->belongsTo(config('tipoff.model_class.room'));
    }

    /**
     * Scope a query to rows visible by user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleBy($query, $user)
    {
        return $query;
    }
}
