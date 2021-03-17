<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Game extends BaseResource
{
    public static $model = \Tipoff\Scheduler\Models\Game::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [
        \Tipoff\EscapeRoom\Filters\Room::class,
        \Tipoff\EscapeRoom\Filters\RoomLocation::class,
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasRole([
            'Admin',
            'Owner',
            'Accountant',
            'Executive',
            'Reservation Manager',
            'Reservationist',
        ])) {
            return $query;
        }

        return $query->whereHas('room', function ($roomlocation) use ($request) {
            return $roomlocation->whereIn('location_id', $request->user()->locations->pluck('id'));
        });
    }

    public static $group = 'Operations';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Game Number')->sortable(),
            nova('room') ? BelongsTo::make('Room', 'room', nova('room'))->sortable() : null,
            Date::make('Date')->sortable(),
            Date::make('Initiated At')->sortable(),
            nova('user') ? BelongsTo::make('Monitor', 'monitor', nova('user'))->sortable() : null,
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Game Number')->exceptOnForms(),
            BelongsTo::make('EscaperoomSlot')->hideWhenUpdating(),
            nova('room') ? BelongsTo::make('Room', 'room', nova('room'))->exceptOnForms() : null,
            Date::make('Date')->exceptOnForms(),
            DateTime::make('Initiated At')->hideWhenCreating(),
            Number::make('Participants')->exceptOnForms(),
            Boolean::make('Finished')->exceptOnForms(),
            Boolean::make('Escaped')->exceptOnForms(),
            Number::make('Time (seconds)', 'time')->nullable(),
            Number::make('Clues')->nullable(),
            Boolean::make('Reached Final Stage')->nullable(),
            nova('supervision') ? BelongsTo::make('Supervision', 'supervision', nova('supervision'))->nullable()->exceptOnForms() : null,
            nova('user') ? BelongsTo::make('Monitor', 'monitor', nova('user'))->nullable() : null,
            nova('user') ? BelongsTo::make('Receptionist', 'receptionist', nova('user'))->nullable() : null,
            nova('user') ? BelongsTo::make('Manager', 'manager', nova('user'))->nullable() : null,
            MorphMany::make('Notes'),

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return array_filter([
            ID::make(),
            DateTime::make('Created At')->exceptOnForms(),
            nova('user') ? BelongsTo::make('Updated By', 'updater', nova('user'))->exceptOnForms() : null,
            DateTime::make('Updated At')->exceptOnForms(),
        ]);
    }
}
