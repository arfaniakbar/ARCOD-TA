<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class GlobalModel extends Model
{
    public static function getAllRecords($table)
    {
        return DB::table($table)->get();
    }

    public static function getRecordById($table, $id)
    {
        return DB::table($table)->where('id', $id)->first();
    }
    public static function deleteRecordById($table, $id)
    {
        return DB::table($table)->where('id', $id)->delete();
    }
    public static function insertRecord($table, $data)
    {
        return DB::table($table)->insertGetId($data);
    }
    public static function updateRecordById($table, $id, $data)
    {
        return DB::table($table)->where('id', $id)->update($data);
    }
    public static function getRecordsByColumn($table, $column, $value)
    {
        return DB::table($table)->where($column, $value)->get();
    }
    public static function getLatestRecords($table, $limit = 10)
    {
        return DB::table($table)->latest()->limit($limit)->get();
    }
    public static function countRecords($table)
    {
        return DB::table($table)->count();
    }
    public static function getPaginatedRecords($table, $perPage = 15)
    {
        return DB::table($table)->paginate($perPage);
    }
    public static function getRecordsWithCondition($table, $conditions = [])
    {
        $query = DB::table($table);
        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }
        return $query->get();
    }
    public static function getRecordsWithSorting($table, $column, $direction = 'asc')
    {
        return DB::table($table)->orderBy($column, $direction)->get();
    }
    public static function getRecordsWithLimit($table, $limit)
    {
        return DB::table($table)->limit($limit)->get();
    }
    public static function getDistinctValues($table, $column)
    {
        return DB::table($table)->distinct()->pluck($column);
    }
    public static function getSumOfColumn($table, $column)
    {
        return DB::table($table)->sum($column);
    }
    public static function getAverageOfColumn($table, $column)
    {
        return DB::table($table)->avg($column);
    }
    public static function getMaxOfColumn($table, $column)
    {
        return DB::table($table)->max($column);
    }
    public static function getMinOfColumn($table, $column)
    {
        return DB::table($table)->min($column);
    }
}
