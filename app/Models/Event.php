<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    /**
     * Remove updated_at as auto managed by laravel
     */
    const UPDATED_AT = null;

    /**
     * Specify attribute here if you want it to not be mass 
     * assinable. By default all attributes are mass assinable.
     *
     * @var <array>
     */
    protected $guarded = [];

    /**
     * Will hold MessageBag from validation
     */
    public $errors = null;

     /**
     * Custom validator
     *
     * @return <array | boolean>
     */
    public function validate()
    {
        $validator = Validator::make($this->attributes, [
            'user_id' => 'required|integer',
            'event_name' => 'required|string',
            'event_start' => 'required|date',
            'event_end' => 'required|date',
            'included_days' => 'required|string',
            'created_at' => 'required|date',
            'updated_at' => 'nullable|date',
            'deleted_at' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }

        $this->errors = null;
        return true;
    }

    /**
     * Append a where clause contraining data with it start and end date
     *
     * @param $query <Builder> - @inherit
     * @param $dates <array> - date constraints
     */
    public function scopeBetweenDates($query, Array $dates)
    {
        $start = $dates['start'];
        $end = $dates['end'];

        $columnStart = "CONVERT_TZ({$this->getTable()}.event_start, '+00:00', '" . date('P') . "')";
        $columnEnd = "CONVERT_TZ({$this->getTable()}.event_end, '+00:00', '" . date('P') . "')";
        // $columnEnd = $this->getTable() . '.event_end';

        $query->whereRaw(
            '("' . $start . '" BETWEEN ' . $columnStart . ' AND ' . $columnEnd . '
            OR
            "' . $end . '" BETWEEN ' . $columnStart . ' AND ' . $columnEnd . '
            OR
            ' . $columnStart . ' BETWEEN "' . $start . '" AND "' . $end . '"
            OR
            ' . $columnEnd . ' BETWEEN "' . $start . '" AND "' . $end . '")'
        );
    }
}