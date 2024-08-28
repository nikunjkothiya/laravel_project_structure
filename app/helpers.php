<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * function for get serialize data from raw data.
 *
 * @param  mixed $searchResult
 * @return mixed $searchResult
 */
function serializationReturnData($searchResult)
{
    $returndata = array();
    $strArray = explode("&", $searchResult);
    foreach ($strArray as $item) {
        $array = explode("=", $item);
        $returndata[$array[0]] = $array[1];
    }
    return $returndata;
}

/**
 * [begin description]
 * @return [type] [description]
 */
function begin()
{
    return DB::beginTransaction();
}

/**
 * [commit description]
 * @return [type] [description]
 */
function commit()
{
    return DB::commit();
}

/**
 * [rollback description]
 * @return [type] [description]
 */
function rollback()
{
    return DB::rollBack();
}

/**
 * common function for upload image.
 *
 * @param  string $storage_path, string $file_path
 * @return string $stored_file_path
 */

function commonUploadImage($storage_path, $file_path)
{
    $storage_path = $storage_path;
    return Storage::disk('private')->put($storage_path, file_get_contents($file_path));
}

/**
 * function for get current login user info.
 *
 * @param  string $guard
 * @return mixed $info
 */
function getAuthUser()
{
    return Auth::user();
}

/**
 * function for check unique column value from same table during add entry.
 *
 * @return bool
 */
function saveUniqueRuleCheck($table, $column)
{
    return Rule::unique($table, $column);
}

/**
 * function for check unique column value from same table during update entry.
 *
 * @return bool
 */
function editUniqueRuleCheck($table, $column, $id)
{
    return Rule::unique($table, $column)->ignore($id);
}

/**
 * function for set limit to long string.
 *
 * @param string $string integer $length
 * @return string value
 */
function stringEllipsis($string, $length)
{
    return \Illuminate\Support\Str::limit($string, $length, $end = '.....');
}

/**
 * function for convert Json array to string comma seprated.
 *
 * @param string $value
 * @return string path
 */
function convertJsonTostring($jsonArray)
{
    $stringArray = json_decode($jsonArray);
    return implode(', ', $stringArray);
}

/**
 * function for format price.
 *
 * @param integer $total
 * @return float number_format
 */
function formatPrice($total, $decimals = 5)
{
    if (isset($total) && $total >= 0) {
        $formattedTotal = number_format($total, $decimals, '.', ',');
        return $formattedTotal;
    }
    return number_format(0, $decimals, '.', ',');
}
