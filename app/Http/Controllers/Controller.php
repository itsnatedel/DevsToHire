<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * curateSkills method.
     * Strips the ", [ and ] from the skills strings.
     *
     * @param string $skillsSet
     *
     * @return array
     */
    public static function curateSkills(string $skillsSet): array
    {
        $skills = explode(',', $skillsSet);

        $curatedArrSkills = [];

        foreach($skills as $skill) {
            $curatedArrSkills[] = preg_replace('/[\W\b]/','', $skill);
        }

        return $curatedArrSkills;
    }

    /**
     * curateSignInDate method.
     *
     * Strips the '-' character from the string
     * Outputs the number of days / years since the member has joined the platform
     * @param string $days
     *
     * @return string
     */
    public static function curateSignInDate(string $days): string
    {
        $amountDays = substr($days, 1);
        $daysPerYear = 365;

        if (empty($amountDays)) {
            return '0 day';
        }
        if ($amountDays > 364) {
            for ($i = 1; $i <= 5; $i++) {
                // If $amountDays between 365 * $i and 365 * $i + 1
                if ($amountDays >= ($daysPerYear * $i) && $amountDays < ($daysPerYear * ($i + 1))) {
                    return $i > 1
                        ? $i . ' years'
                        : $i . ' year';
                }

                if ($i === 5 && $amountDays >= ($daysPerYear * $i + 1)) {
                    return $i + 1 . '+ years';
                }
            }
        }

        return $amountDays > 1
            ? $amountDays . ' days'
            : $amountDays . ' day';
    }
}
