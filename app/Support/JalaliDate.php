<?php

namespace App\Support;

use Carbon\CarbonInterface;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class JalaliDate
{
    public static function nowMonth(): string
    {
        return self::format(now(), 'Y/m');
    }

    public static function format(DateTimeInterface|string|null $date, string $format = 'Y/m/d H:i'): string
    {
        if (!$date) {
            return '-';
        }

        $carbon = self::toCarbon($date);
        [$year, $month, $day] = self::gregorianToJalali(
            (int) $carbon->format('Y'),
            (int) $carbon->format('m'),
            (int) $carbon->format('d')
        );

        $replacements = [
            'Y' => sprintf('%04d', $year),
            'y' => substr((string) $year, -2),
            'm' => sprintf('%02d', $month),
            'n' => (string) $month,
            'd' => sprintf('%02d', $day),
            'j' => (string) $day,
            'H' => $carbon->format('H'),
            'i' => $carbon->format('i'),
            's' => $carbon->format('s'),
        ];

        return strtr($format, $replacements);
    }

    public static function toGregorianDate(?string $jalaliDate): ?string
    {
        if (!$jalaliDate) {
            return null;
        }

        $normalized = str_replace(['-', '.', ' '], '/', trim(self::persianDigitsToEnglish($jalaliDate)));
        $parts = array_values(array_filter(explode('/', $normalized), fn ($part) => $part !== ''));

        if (count($parts) !== 3) {
            throw new InvalidArgumentException('فرمت تاریخ شمسی باید به صورت 1403/02/15 باشد.');
        }

        [$year, $month, $day] = array_map('intval', $parts);

        if ($year < 1200 || $month < 1 || $month > 12 || $day < 1 || $day > 31) {
            throw new InvalidArgumentException('تاریخ شمسی وارد شده معتبر نیست.');
        }

        [$gy, $gm, $gd] = self::jalaliToGregorian($year, $month, $day);

        return sprintf('%04d-%02d-%02d', $gy, $gm, $gd);
    }

    public static function persianDigitsToEnglish(string $value): string
    {
        return strtr($value, [
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
            '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
            '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
        ]);
    }

    public static function gregorianToJalali(int $gy, int $gm, int $gd): array
    {
        $gDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $jDaysInMonth = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

        $gy -= 1600;
        $gm -= 1;
        $gd -= 1;

        $gDayNo = 365 * $gy + intdiv($gy + 3, 4) - intdiv($gy + 99, 100) + intdiv($gy + 399, 400);

        for ($i = 0; $i < $gm; $i++) {
            $gDayNo += $gDaysInMonth[$i];
        }

        if ($gm > 1 && (($gy + 1600) % 4 === 0 && (($gy + 1600) % 100 !== 0 || ($gy + 1600) % 400 === 0))) {
            $gDayNo++;
        }

        $gDayNo += $gd;
        $jDayNo = $gDayNo - 79;
        $jNp = intdiv($jDayNo, 12053);
        $jDayNo %= 12053;
        $jy = 979 + 33 * $jNp + 4 * intdiv($jDayNo, 1461);
        $jDayNo %= 1461;

        if ($jDayNo >= 366) {
            $jy += intdiv($jDayNo - 1, 365);
            $jDayNo = ($jDayNo - 1) % 365;
        }

        for ($i = 0; $i < 11 && $jDayNo >= $jDaysInMonth[$i]; $i++) {
            $jDayNo -= $jDaysInMonth[$i];
        }

        return [$jy, $i + 1, $jDayNo + 1];
    }

    public static function jalaliToGregorian(int $jy, int $jm, int $jd): array
    {
        $gDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $jDaysInMonth = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

        $jy -= 979;
        $jm -= 1;
        $jd -= 1;

        $jDayNo = 365 * $jy + intdiv($jy, 33) * 8 + intdiv(($jy % 33) + 3, 4);

        for ($i = 0; $i < $jm; $i++) {
            $jDayNo += $jDaysInMonth[$i];
        }

        $jDayNo += $jd;
        $gDayNo = $jDayNo + 79;
        $gy = 1600 + 400 * intdiv($gDayNo, 146097);
        $gDayNo %= 146097;
        $leap = true;

        if ($gDayNo >= 36525) {
            $gDayNo--;
            $gy += 100 * intdiv($gDayNo, 36524);
            $gDayNo %= 36524;

            if ($gDayNo >= 365) {
                $gDayNo++;
            } else {
                $leap = false;
            }
        }

        $gy += 4 * intdiv($gDayNo, 1461);
        $gDayNo %= 1461;

        if ($gDayNo >= 366) {
            $leap = false;
            $gDayNo--;
            $gy += intdiv($gDayNo, 365);
            $gDayNo %= 365;
        }

        for ($i = 0; $gDayNo >= $gDaysInMonth[$i] + ($i === 1 && $leap ? 1 : 0); $i++) {
            $gDayNo -= $gDaysInMonth[$i] + ($i === 1 && $leap ? 1 : 0);
        }

        return [$gy, $i + 1, $gDayNo + 1];
    }

    private static function toCarbon(DateTimeInterface|string $date): CarbonInterface
    {
        if ($date instanceof CarbonInterface) {
            return $date;
        }

        if ($date instanceof DateTimeInterface) {
            return Carbon::instance($date);
        }

        return Carbon::parse($date);
    }
}
