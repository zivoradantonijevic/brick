<?php

namespace Brick\DateTime;

/**
 * This exception is used to indicate problems with creating, querying
 * and manipulating date-time objects.
 */
class DateTimeException extends \RuntimeException
{
    /**
     * @param string $timeZone
     *
     * @return DateTimeException
     */
    public static function unknownTimeZone($timeZone)
    {
        return new self(sprintf('Unknown time zone (%s)', $timeZone));
    }
}
