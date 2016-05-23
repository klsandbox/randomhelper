<?php

namespace Klsandbox\RandomHelper;

class RandomHelper
{
    public static function randomIcNumber()
    {
        $start = mt_rand(800000, 900000);
        $mid = mt_rand(10, 99);
        $end = mt_rand(1000, 9999);

        return $start . '-' . $mid . '-' . $end;
    }

    public static function getRandomBankAccount()
    {
        $start = mt_rand(100000, 900000);
        $mid = mt_rand(10, 99);
        $end = mt_rand(1000, 9999);

        return $start . $mid . $end;
    }

    public static function getRandomBank()
    {
        $bankNames = ['Maybank', 'Tabung Haji', 'CIMB', 'OCBC', 'Bank Negara'];

        return self::choose_from_array($bankNames);
    }

    public static function getEmailFromName($name)
    {
        $email = str_replace(' ', '', $name) . '@' . config('random_helper.hostname');

        return $email;
    }

    public static function randomMalaysianNameList($count)
    {
        $fakeFirstNameMales = ['Danial', 'Adam', 'Taib', 'Halim', 'Hamzah', 'Omar', 'Ali', 'Hassan', 'Ahmad', 'Alex', 'Megat', 'Abdul jalil', 'Abdul rahman', 'Iskandar', 'Musa', 'Yahya'];
        $fakeModifierMales = ['', '', '', 'En ', 'Dr ', 'Wan ', 'Syed '];

        $fakeFirstNameFemales = ['Hana', 'Sarah', 'Amy', 'Zura', 'Wati', 'Wani', 'Azura', 'Aishah', 'Azizah', 'Hani', 'Huda'];
        $fakeModifierFemales = ['', '', '', 'Siti ', 'Sharifah ', 'Nurul '];

        $lastNames = array_values(array_filter($fakeFirstNameMales, function ($v) {
                    return $v != 'Alex';
                }));

        $hash = [];

        $genderMale = true;
        for ($ctr = 0; $ctr < $count * 2; ++$ctr) {
            $genderMale = !$genderMale;

            if ($genderMale) {
                $nameList = $fakeFirstNameMales;
                $modifierList = $fakeModifierMales;
            } else {
                $nameList = $fakeFirstNameFemales;
                $modifierList = $fakeModifierFemales;
            }

            $firstName = $nameList[($ctr / 2) % count($nameList)];
            $firsNameModifier = $modifierList[($ctr / 2) % count($modifierList)];

            $lastName = $lastNames[($ctr / 2) % count($lastNames)];
            $lastNameModifier = $fakeModifierMales[($ctr / 2) % count($fakeModifierMales)];

            $name = $firsNameModifier . $firstName . ' ' . $lastNameModifier . $lastName;

            $hash[$name] = $name;
            $allNames = array_keys($hash);
            if (count($allNames) == $count) {
                break;
            }
        }

        // echo implode(PHP_EOL, array_keys($hash));
        $allNames = array_keys($hash);
        'Completed generating names count:' . count($allNames) . PHP_EOL;

        return array_values($allNames);
    }

    public static function randomMalaysianPhoneNumber()
    {
        $root = self::choose_from_array(['012', '019', '018']);
        $mid = mt_rand(100, 999);
        $end = mt_rand(1000, 9999);

        return $root . '-' . $mid . '-' . $end;
    }

    public static function choose_from_array(array $list)
    {
        assert(count($list), 'Array empty!');

        return $list[mt_rand() % count($list)];
    }

    public static function choose_from_collection(\Illuminate\Database\Eloquent\Collection $collection)
    {
        assert($collection->count(), 'Collection empty!');

        return $collection->get($collection->keys()[mt_rand() % $collection->count()]);
    }

    public static function choose_from_pair($a, $b)
    {
        return mt_rand() % 2 ? $a : $b;
    }

    // http://stackoverflow.com/questions/1972712/generate-random-date-between-two-dates-using-php
    // Find a randomDate between $start_date and $end_date
    public static function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        $date = date('Y-m-d H:i:s', $val);

        //echo "min $min max $max val $val date $date\n";

        return $date;
    }

    public static function randomDateByDaysAgo($days)
    {
        //echo "randomDateByDaysAgo $days]\n";
        $past_stamp = time() - $days * 24 * 60 * 60;
        $past_date = date('Y-m-d', $past_stamp);
        $todays_date = date('Y-m-d', time());

        //echo "$past_date $todays_date\n";

        return self::randomDate($past_date, $todays_date);
    }

    public static function listOfRandomInOrderEventTimestamps($days, $count)
    {
        $list = [];
        for ($ctr = 0; $ctr < $count; ++$ctr) {
            array_push($list, self::randomDateByDaysAgo($days));
        }

        $list = array_sort($list, function ($val, $key) {
            return strtotime($val);
        });

        return array_values($list);
    }

    public static function randomDateToNow($start_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = time();

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        $date = date('Y-m-d H:i:s', $val);

        //echo "min $min max $max val $val date $date\n";

        return $date;
    }
}
