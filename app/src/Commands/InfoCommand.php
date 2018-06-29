<?php


namespace App\Commands;


use App\Components\Db\Interfaces\ConnectionInterface;
use App\Components\Db\Mysql\QueryBuilder;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InfoCommand extends Command
{
    /**
     * @var ConnectionInterface
     */
    private $_connection;

    public function __construct(ConnectionInterface $connection, $name = null)
    {
        $this->_connection = $connection;
        parent::__construct($name);
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->_connection;
    }

    /**
     * Configure Command
     */
    protected function configure()
    {
        $this->setName('app:user:info')
            ->setDescription('Parse user info by identifier.')
            ->addOption('id', null, InputOption::VALUE_OPTIONAL);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $info = $this->getUserInfo($input->getOption('id'));
            $table = new Table($output);
            $table->setHeaders(array('Owner Id', 'Album Title', 'Photo Url'))
                ->setRows($info)
                ->render();
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
        }
    }

    public function getUserInfo(?string $ownerId)
    {
        $bindings = [];
        $query = "SELECT user.owner_id, a.title, p.url FROM user LEFT JOIN album a on user.id = a.user_id LEFT JOIN photo p on a.id = p.album_id ";
        if (!empty($ownerId)) {
            $query .= " WHERE user.owner_id = :owner_id";
            $bindings = [':owner_id' => $ownerId];
        }
        $userInfo = (new QueryBuilder())
            ->select($query, $bindings)
            ->fetchAll($this->getConnection());
        return $userInfo;
    }

}