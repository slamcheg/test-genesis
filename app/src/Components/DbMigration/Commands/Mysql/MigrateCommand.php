<?php


namespace App\Components\DbMigration\Commands\Mysql;


use App\Components\Db\Mysql\Interfaces\MysqlConnectionInterface;
use App\Components\DbMigration\Mysql\Executor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
    private $_migrations;
    private $_connection;

    public function __construct(MysqlConnectionInterface $connection, array $migrations = [], $name = null)
    {
        $this->_connection = $connection;
        $this->_migrations = $migrations;
        parent::__construct($name);
    }

    /**
     * Configure Command
     */
    protected function configure()
    {
        $this->setName('db:migrate')
            ->setDescription('Run migrations')
            ->addArgument('make',InputArgument::REQUIRED, 'up||down');
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
            $arg = $input->getArgument('make');
            $executor = new Executor($this->_connection, $this->_migrations);
            if($arg == 'up'){
                $executor->upMigrations();
            }elseif($arg == 'down'){
                $executor->downMigrations();
            }else{
                throw new \Exception('Invalid argument check description');
            }
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }
    }
}