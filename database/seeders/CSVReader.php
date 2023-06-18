<?php

namespace Database\Seeders;

class CSVReader
{
    public function readRows($filename, $delimiter = ',')
    {
        // Reference: https://betterprogramming.pub/how-to-seed-database-from-a-csv-file-in-laravel-83a54ce1015f
        // I didn't follow it completely as I hate putting CSVs on public folder.
        // Ideally csv data, even if it's not sensitive, should be gitignored 
        // and inaccessible to public.
        // 
        // I just put this in a class as well so I can easily inject it instead of
        // polluting the global namespace. I also didn't like that he put it in a
        // global Helper class. While this thing is only used in seeders, I'll
        // keep it in seeders to contextualize it. Might as well make it a
        // Facade if you do that

        if (!file_exists($filename) || !is_readable($filename))
            return false;
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // Note `preg_replace` below. Excel sometimes adds in an invisible 
                // character that messes up our keys: 
                // https://stackoverflow.com/questions/43414804/first-key-of-php-associative-array-returns-undefined-index-when-parsed-from-csv
                if (!$header)
                    $header = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row);
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }    
}
