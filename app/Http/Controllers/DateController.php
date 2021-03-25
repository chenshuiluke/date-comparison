<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DateRequest;

const MONTH_INDEX=0;
const DAY_INDEX=1;
const YEAR_INDEX=2;

class DateController extends Controller
{
    private $months_with_30_days = [
        9,
        4,
        6,
        11
    ];
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(DateRequest $request)
    {
        $date_one = $request->date_one;
        $date_two = $request->date_two;
        
        $date_one_parts = explode('/', $date_one);
        $date_two_parts = explode('/', $date_two);
        // dd($date_one_parts);
        $days_from_first_date = $this->getNumberOfDays($date_one_parts);
        $days_from_second_date = $this->getNumberOfDays($date_two_parts);
        
        
        $diff = abs($days_from_first_date - $days_from_second_date);

        dd($diff);
    }

    private function getNumberOfDays($date_parts) 
    {
        $year = $date_parts[YEAR_INDEX];
        $month = $date_parts[MONTH_INDEX];
        $days = $date_parts[DAY_INDEX];
        $days_from_years = $this->getNumberOfDaysFromYears($year);
        $days_from_leap_years = $this->getNumberOfDaysFromLeapYears($year, $month);

        $days_from_month = $this->getNumberOfDaysFromMonth($month, $year);
        // dd($days_from_years, $days_from_leap_years, $days_from_month, $days);
        return $days_from_years + $days_from_leap_years + $days_from_month + $days;
    }

    private function isLeapYear($year) 
    {
        if($year % 4 == 0) {
            if($year % 100 == 0) {
                if($year % 400 == 0) {
                    return true;
                }
                return false;
            }
            return true;
        }
        return false;
    }

    private function getNumberOfDaysFromMonth($month, $year)
    {
        $diff = 0;
        for($counter = 1; $counter < $month; $counter++) {
            if(in_array($counter, $this->months_with_30_days)) {
                $diff += 30;
            }
            else if($counter == 2) {
                
                if($this->isLeapYear($year)) {
                    $diff += 29;
                   
                }
                else {
                    $diff += 28;
                }
            }
            else {
                $diff += 31;
            }
        }
        return $diff;
    }

    private function getNumberOfDaysFromYears($year) 
    {
        return $year * 365;
    }

    private function getNumberOfDaysFromLeapYears($year, $month)
    {
        if($month < 2) {
            dd("here");
            $year--;
        }
        $leap_years = 0;
        for($count = 0; $count <= $year; $count++) {
            if($this->isLeapYear($count)) {
                $leap_years++;
            }
        }

        return $leap_years * 366;
    }
}
