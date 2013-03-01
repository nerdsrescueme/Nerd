<?php

namespace CMS\Tests\Entity;

use PHPUnit_Framework_TestCase;

/**
 * A Simple Test Case used for testing Doctrine ORM
 * 
 * @see https://github.com/MelbSymfony2/Doctrine2-Test-Case-Boiler-Plate
 */
class EntityTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    static $sqlLogger;

    /**
     * @var int
     */
    private $queryCount = 0;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \Doctrine\Common\EventManager
     */
    private $eventManager;

    private $fixtureLoader;
    protected $fixtureDir;
    private $fixtureReferenceRepository;

    /**
     * @var array
     */
    protected $paths = array();

    /**
     * @var string
     */
    protected $resource;

    /**
     * Set up called prior to running tests
     * @return void
     */
    protected function setUp()
    {
        //
    }

    /**
     * Tear down process run after tests
     * @return void
     */
    protected function tearDown()
    {
        //
    }

    /**
     * Loads a fixture
     * @throws \Exception
     * @param $fixtureClass
     * @return void
     */
    public function loadFixtures()
    {
        if ($this->fixtureLoader !== null) {
            throw new \LogicException('Fixtures already loaded');
        }

        $this->fixtureLoader = new \Doctrine\Common\DataFixtures\Loader;
        $this->fixtureDir = $this->fixtureDir ?: __DIR__.'/Fixture';
        $this->fixtureLoader->loadFromDirectory($this->fixtureDir);


        // Inject shared fixtureReferenceRepository repository into each fixture
        $this->fixtureReferenceRepository = new \Doctrine\Common\DataFixtures\ReferenceRepository($this->getEntityManager());
        foreach ($this->fixtureLoader->getFixtures() as $fixture) {
            $fixture->setReferenceRepository($this->fixtureReferenceRepository);
        }

        // Load each fixture (ordered by dependecy)
        foreach ($this->fixtureLoader->getFixtures() as $fixture) {
            $fixture->load($this->getEntityManager());
        }
    }

    /**
     * Resets the query counter index
     * @return void
     */
    public function resetQueryCount()
    {
        if(!empty(self::$sqlLogger)) {
            $this->queryCount = count(self::$sqlLogger->queries);
        }
    }

    /**
     * Returns with the number of queries since last reset of counter
     * @return int
     */
    public function getQueryCount()
    {
        if(!empty(self::$sqlLogger)) {
            return count(self::$sqlLogger->queries) - $this->queryCount;
        }
    }

    public function getRepository($class)
    {
        return $this->getEntityManager()->getRepository('\CMS\Entity\\'.$class);
    }

    /**
     * Load a database schema into the database
     * @param $entityClasses array of FQCN
     * @return void
     */
    public function loadSchemas(array $entityClasses)
    {
        $this->dropDatabase();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->getEntityManager());
        $classes = array();

        foreach ($entityClasses as $className) {
            $classes[] = $this->getEntityManager()->getClassMetadata($className);
        }

        if (!empty($classes)) {
            $schemaTool->createSchema($classes);
        }
    }

    /**
     * Add doctrine event manager lifecycle listener
     * 
     * @param $listener
     * @return void
     */
    public function addLifecycleEventListener($events = array(), $listener)
    {
        $this->eventManager->addEventListener($events, $listener);
    }

    /**
     * Add doctrine event manager lifecycle event subscriber
     *
     * @param $subscriber
     * @return void
     */
    public function addLifecycleEventSubscriber($subscriber)
    {
        $this->eventManager->addEventSubscriber($subscriber);
    }

    /**
     * Returns with the initialised entity manager
     * @throws
     * @return
     */
    public function getEntityManager()
    {
        // If we have an entity manager return it
        if(!empty($this->entityManager)) return $this->entityManager;

        // Register a new entity
        $this->eventManager = new \Doctrine\Common\EventManager();

        // TODO: Register Listeners
        $conn = array(
            'driver' => 'pdo_sqlite',
            'path' => $this->resource,
            'memory' => true
        );
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($this->paths, true);
        if (!$config->getMetadataDriverImpl()) {
            throw ORMException::missingMappingDriverImpl();
        }

        // Setup use of SQL Logger
        if(empty(self::$sqlLogger)) {
            self::$sqlLogger = new \Doctrine\DBAL\Logging\DebugStack;
        }

        //$config->setResultCacheImpl(new \Doctrine\Common\Cache\MemcacheCache('localhost', '11211'));

        $config->setSQLLogger(self::$sqlLogger);
        $conn = \Doctrine\DBAL\DriverManager::getConnection($conn, $config, $this->eventManager);
        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config, $conn->getEventManager());
        return $this->entityManager;
    }

    /**
     * Drop the entity manager
     * @return void
     */
    public function dropEntityManager()
    {
        $this->entityManager = null;
    }

    /**
     * Drop the database file
     * @return void
     */
    public function dropDatabase()
    {
        $this->dropEntityManager();
    }

    /**
     * @return string
     */
    public function getResource()
    {
        if(!empty($this->resources)) return __DIR__ . '/../../storage/db/test.db';
    }
}