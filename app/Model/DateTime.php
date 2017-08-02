<?php

namespace App\Model;

use Carbon\Carbon;

/**
 * let timezone config outside.
 */
final class DateTime extends Carbon
{
    const MYSQL = 'Y-m-d H:i:s';
    public function __construct($time = null, $tz = null)
    {
        $tz = $tz ?? config('app.timezone');
        parent::__construct($time, $tz);
    }
    /**
     * @override
     * @param  string $format         [description]
     * @return string [description]
     */
    public function format($format = null)
    {
        $format = $format ?? self::MYSQL;
        return parent::format($format);
    }
    /**
     * @override
     * @param  string $format         [description]
     * @return string [description]
     */
    public function formatLocalized($format = null)
    {
        $format = $format ?? '%Y-%m-%d %T';
        return parent::formatLocalized($format);
    }
}
