<?php
namespace App\Models;

class AutoIdGenerator {

    private $prefix;
    private $date_format;
    private $counter_file;
    private $counter_length;

    public function __construct($prefix = 'ID_', $date_format = 'ymd', $counter_file = 'counter.txt', $counter_length = 4) {
        $this->prefix = $prefix;
        $this->date_format = $date_format;
        $this->counter_file = $counter_file;
        $this->counter_length = $counter_length;
    }

    public function generateId() {
        $date = date($this->date_format);
        $counter = $this->getCounter();
        $paddedCounter = str_pad($counter, $this->counter_length, '0', STR_PAD_LEFT);
        $id = $this->prefix . $date . $paddedCounter;
        $this->incrementCounter();
        return $id;
    }

    private function getCounter() {
        if (!file_exists($this->counter_file)) {
            $this->initializeCounter();
        }
        $counter = (int)file_get_contents($this->counter_file);
        return $counter;
    }

    private function incrementCounter() {
        $counter = $this->getCounter();
        $counter++;
        file_put_contents($this->counter_file, $counter);
    }

    private function initializeCounter() {
        file_put_contents($this->counter_file, '1');
    }
}

// Example usage:
$idGenerator = new AutoIdGenerator();
$uniqueId = $idGenerator->generateId();
echo "Generated ID: " . $uniqueId . "\n"; 

?>