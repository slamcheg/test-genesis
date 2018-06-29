<?php

namespace App\Commands;


use App\Components\CsvLoader\Loader;
use App\Components\Db\Interfaces\ConnectionInterface;
use App\Components\Parser\Parser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class VkCommand extends Command
{
    /**
     * @var Parser;
     */
    private $_parser;

    private $basePath;

    public function __construct(string $vkServiceKey, ConnectionInterface $connection, string $basePath, $name = null)
    {
        $this->_parser = new Parser($vkServiceKey, $connection);
        $this->basePath = $basePath;
        parent::__construct($name);
    }

    /**
     * Configure Command
     */
    protected function configure()
    {
        $this->setName('app:parse')
            ->setDescription('Parse user info by identifier.')
            ->addOption('id', null, InputOption::VALUE_OPTIONAL)
            ->addOption('csv', null, InputOption::VALUE_OPTIONAL);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->validateOptions($input);
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }
    }

    /**
     * @param string $id
     * @throws \Exception
     */
    private function parseById(string $id)
    {
        $this->_parser->parseSingleUser($id);
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    private function parseCsv(string $path)
    {
        $loader = new Loader($this->basePath . '/' . $path);
        $vkIds = $loader->getData();
        if (!empty($vkIds)) {
            foreach ($vkIds as $id) {
                $this->_parser->parseSingleUser($id);
            }
        }
    }

    /**
     * @param InputInterface $input
     * @throws \Exception
     */
    private function validateOptions(InputInterface $input)
    {
        if (!empty($input->getOption('csv'))) {
            return $this->parseCsv($input->getOption('csv'));
        }
        if (!empty($input->getOption('id'))) {
            return $this->parseById($input->getOption('id'));
        }
        throw  new \Exception('You must choice option: [--id, --csv].');
    }
}