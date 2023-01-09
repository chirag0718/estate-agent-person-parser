<?php

namespace App\Services;
use App\Repositories\PersonsRepository;
use Generator;

/**
 * @author Chiragkumar Patel
 */
class PersonsService
{

    protected PersonsRepository $persons_repository;
    public const TITLES = ['mr', 'mrs', 'ms', 'miss', 'dr', 'mister', 'prof'];

    /**
     * @param PersonsRepository $persons_repository
     */
    public function __construct(PersonsRepository $persons_repository)
    {
        $this->persons_repository = $persons_repository;
    }

    /**
     * Reading csv file using generator
     * @param string $filePath
     * @return Generator
     */
    public function readCSV(string $filePath): Generator
    {
        $f = fopen($filePath, 'r');
        $firstRow = true;
        while (($line = fgetcsv($f)) !== false) {
            if ($firstRow) {
                $firstRow = false;
                continue;
            }
            yield $line;
        }

        fclose($f);
    }

    /**
     * Parsing the csv file and storing in db.
     * @param string $csvData
     * @return array
     */
    public function parse(string $csvData): array
    {
        $people = [];
        foreach (self::readCSV($csvData) as $data) {

            // Taking first column
            $data = $data[0];

            if (empty($data)) {
                continue;
                //throw new InitializationException("Data is empty");
            }

            // Split data if and or & found
            $names = preg_split('/( and )|( & )/', $data);

            // Update the last name if not present
            if (count($names) > 1) {
                $first = explode(" ", $names[0]);
                $second = explode(" ", $names[1]);
                if (count($first) == 1 and count($second) > 1) {
                    $names[0] = $names[0] . ' ' . end($second);
                }
            }

            if (!empty($names)) {
                // Start with person empty array
                $person = [
                    'title' => null,
                    'first_name' => null,
                    'initial_name' => null,
                    'last_name' => null,
                ];
                foreach ($names as $name) {

                    // Split the string into words
                    $words = preg_split('/\s+/', $name);

                    // first we catch any title present in array
                    if (in_array(strtolower($words[0]), self::TITLES)) {
                        $person['title'] = $words[0];
                        array_shift($words);
                    }

                    // then catch last_name field
                    $person['last_name'] = array_pop($words);

                    // Get initial letters by counting
                    if (!empty($words) && strlen($words[0]) > 1) {
                        $person['first_name'] = $words[0];
                        array_shift($words);
                    }

                    // Get initial name
                    if (!empty($words) && strlen($words[0]) == 1) {
                        $person['initial_name'] = $words[0];
                        array_shift($words);
                    }

                    // Storing all person data into people.
                    $people[] = $this->persons_repository->create($person);
                }
            }
        }
        return $people;
    }
}
