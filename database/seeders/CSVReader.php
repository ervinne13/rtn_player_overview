<?php

namespace Database\Seeders;

/**
 * TODO: Technical Debt
 * 
 * Note that readRows is a technical debt, it's a modded version from betterprogramming
 * that allows for buffered reads. Ideally the two should be separate but let's work with
 * this for now as we have limited time.
 */
class CSVReader
{
    public function readRows($filename, $delimiter = ',', $buffer = null, $bufferSize = null)
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

        $previousBufferPointer = $buffer ? $buffer['pointer'] : 0;

        if (!$buffer) {
            $buffer = [
                'content' => [],
                'pointer' => 0
            ];
        }   

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    // Note `preg_replace` below. Excel sometimes adds in an invisible 
                    // character that messes up our keys: 
                    // https://stackoverflow.com/questions/43414804/first-key-of-php-associative-array-returns-undefined-index-when-parsed-from-csv
                    $header = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row);
                    $buffer['pointer']++;
                } else if ($previousBufferPointer < $buffer['pointer']) {
                    // Not the best solution right now, but let's avoid overloading the
                    // machine's ram by skipping contents based on the pointer.
                    $buffer['content'][] = array_combine($header, $row);
                    $buffer['pointer']++;
                }

                $reachedBufferLimit = ($previousBufferPointer + $bufferSize) < $buffer['pointer'];
                if ($bufferSize > 0 && $reachedBufferLimit) {
                    break;
                }
            }
            fclose($handle);
        }

        if ($bufferSize == null) {
            return $buffer['content'];
        }

        return $buffer;
    }
  }