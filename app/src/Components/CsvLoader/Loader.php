<?php

namespace App\Components\CsvLoader;

/**
 * Class Loader
 * @package App\Components\CsvLoader
 */
class Loader
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var int
     */
    private $length;

    /**
     * @var array
     */
    private $data;

    /**
     * @var resource
     */
    private $fp;

    /**
     * Loader constructor.
     * @param string $path
     * @param string $delimiter
     * @param int $length
     */
    public function __construct(string $path, string $delimiter = ',', int $length = 1000)
    {
        $this->path = $path;
        $this->delimiter = $delimiter;
        $this->length = $length;
        $this->data = [];
        $this->fp = false;
    }

    /**
     * Clear data
     */
    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getData(): array
    {
        if (empty($this->data)) {
            $this->openFile($this->path);
            if ($this->fp !== false) {
                $this->data = fgetcsv($this->fp, 1000, $this->delimiter);
                $this->closeFile();
            }
        }
        return $this->data;
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    private function openFile(string $path): void
    {

        if (!file_exists($path)) {
            throw new \Exception('File not found by this path: ' . $path);
        }
        $this->fp = fopen($this->path, "r");
    }

    /**
     *
     */
    private function closeFile(): void
    {
        fclose($this->fp);
    }


}