<?php

namespace Brick\Tests\DateTime;

use Brick\DateTime\Period;

/**
 * Unit tests for class Period.
 */
class PeriodTest extends AbstractTestCase
{
    public function testZero()
    {
        $this->assertPeriodEquals(0, 0, 0, Period::zero());
    }

    public function testOf()
    {
        $this->assertPeriodEquals(6, 5, 4, Period::of(6, 5, 4));
    }

    public function testPlusYears()
    {
        $this->assertPeriodEquals(11, 2, 3, Period::of(1, 2, 3)->plusYears(10));
    }

    public function testPlusMonths()
    {
        $this->assertPeriodEquals(1, 12, 3, Period::of(1, 2, 3)->plusMonths(10));
    }

    public function testPlusDays()
    {
        $this->assertPeriodEquals(1, 2, 13, Period::of(1, 2, 3)->plusDays(10));
    }

    public function testWithYears()
    {
        $this->assertPeriodEquals(9, 2, 3, Period::of(1, 2, 3)->withYears(9));
    }

    public function testWithMonths()
    {
        $this->assertPeriodEquals(1, 9, 3, Period::of(1, 2, 3)->withMonths(9));
    }

    public function testWithDays()
    {
        $this->assertPeriodEquals(1, 2, 9, Period::of(1, 2, 3)->withDays(9));
    }

    /**
     * @dataProvider providerIsZero
     *
     * @param integer $years  The number of years in the period.
     * @param integer $months The number of months in the period.
     * @param integer $days   The number of days in the period.
     * @param boolean $isZero The expected return value.
     */
    public function testIsZero($years, $months, $days, $isZero)
    {
        $this->assertSame($isZero, Period::of($years, $months, $days)->isZero());
    }

    /**
     * @return array
     */
    public function providerIsZero()
    {
        return [
            [0, 0, 0, true],
            [1, 0, 0, false],
            [0, 1, 0, false],
            [0, 0, 1, false]
        ];
    }

    /**
     * @dataProvider providerIsEqualTo
     *
     * @param integer $y1      The number of years in the 1st period.
     * @param integer $m1      The number of months in the 1st period.
     * @param integer $d1      The number of days in the 1st period.
     * @param integer $y2      The number of years in the 2nd period.
     * @param integer $m2      The number of months in the 2nd period.
     * @param integer $d2      The number of days in the 2nd period.
     * @param boolean $isEqual The expected return value.
     */
    public function testIsEqualTo($y1, $m1, $d1, $y2, $m2, $d2, $isEqual)
    {
        $p1 = Period::of($y1, $m1, $d1);
        $p2 = Period::of($y2, $m2, $d2);

        $this->assertSame($isEqual, $p1->isEqualTo($p2));
        $this->assertSame($isEqual, $p2->isEqualTo($p1));
    }

    /**
     * @return array
     */
    public function providerIsEqualTo()
    {
        return [
            [0, 0, 0, 0, 0, 0, true],
            [0, 0, 0, 0, 0, 1, false],
            [0, 0, 0, 0, 0, -1, false],
            [1, 1, 1, 1, 1, 1, true],
            [1, 1, 1, 1, 2, 1, false],
            [-1, -1, -1, -1, -1, -1, true],
            [-1, -1, -1, -1, -2, -1, false],
            [2, 2, 2, 2, 2, 2, true],
            [2, 2, 2, 3, 2, 2, false],
            [-2, -2, -2, -2, -2, -2, true],
            [-2, -2, -2, -3, -2, -2, false],
        ];
    }

    /**
     * @dataProvider providerToDateInterval
     *
     * @param integer $years
     * @param integer $months
     * @param integer $days
     */
    public function testToDateInterval($years, $months, $days)
    {
        $period = Period::of($years, $months, $days);
        $dateInterval = $period->toDateInterval();

        $this->assertEquals($years, $dateInterval->y);
        $this->assertEquals($months, $dateInterval->m);
        $this->assertEquals($days, $dateInterval->d);
    }

    /**
     * @return array
     */
    public function providerToDateInterval()
    {
        return [
            [1, -2, 3],
            [-1, 2, -3]
        ];
    }

    /**
     * *@dataProvider providerToString
     *
     * @param integer $years    The number of years in the period.
     * @param integer $months   The number of months in the period.
     * @param integer $days     The number of days in the period.
     * @param string  $expected The expected string output.
     */
    public function testToString($years, $months, $days, $expected)
    {
        $this->assertSame($expected, (string) Period::of($years, $months, $days));
    }

    /**
     * @return array
     */
    public function providerToString()
    {
        return [
            [0, 0, 0, 'P0D'],
            [0, 0, 1, 'P1D'],
            [0, 1, 0, 'P1M'],
            [0, 1, 2, 'P1M2D'],
            [1, 0, 0, 'P1Y'],
            [1, 0, 2, 'P1Y2D'],
            [1, 2, 0, 'P1Y2M'],
            [1, 2, 3, 'P1Y2M3D'],

            [0, 0, -1, 'P-1D'],
            [0, -1, 0, 'P-1M'],
            [0, -1, -2, 'P-1M-2D'],
            [-1, 0, 0, 'P-1Y'],
            [-1, 0, -2, 'P-1Y-2D'],
            [-1, -2, 0, 'P-1Y-2M'],
            [-1, -2, -3, 'P-1Y-2M-3D'],
        ];
    }
}
