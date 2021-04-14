<?php

namespace ContainerMpjTApZ;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder49a97 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer192cd = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiese58bb = [
        
    ];

    public function getConnection()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getConnection', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getMetadataFactory', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getExpressionBuilder', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'beginTransaction', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getCache', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getCache();
    }

    public function transactional($func)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'transactional', array('func' => $func), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->transactional($func);
    }

    public function commit()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'commit', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->commit();
    }

    public function rollback()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'rollback', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getClassMetadata', array('className' => $className), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'createQuery', array('dql' => $dql), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'createNamedQuery', array('name' => $name), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'createQueryBuilder', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'flush', array('entity' => $entity), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'clear', array('entityName' => $entityName), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->clear($entityName);
    }

    public function close()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'close', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->close();
    }

    public function persist($entity)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'persist', array('entity' => $entity), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'remove', array('entity' => $entity), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'refresh', array('entity' => $entity), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'detach', array('entity' => $entity), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'merge', array('entity' => $entity), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getRepository', array('entityName' => $entityName), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'contains', array('entity' => $entity), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getEventManager', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getConfiguration', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'isOpen', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getUnitOfWork', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getProxyFactory', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'initializeObject', array('obj' => $obj), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'getFilters', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'isFiltersStateClean', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'hasFilters', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return $this->valueHolder49a97->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializer192cd = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder49a97) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder49a97 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder49a97->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, '__get', ['name' => $name], $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        if (isset(self::$publicPropertiese58bb[$name])) {
            return $this->valueHolder49a97->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder49a97;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder49a97;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder49a97;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder49a97;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, '__isset', array('name' => $name), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder49a97;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder49a97;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, '__unset', array('name' => $name), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder49a97;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder49a97;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, '__clone', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        $this->valueHolder49a97 = clone $this->valueHolder49a97;
    }

    public function __sleep()
    {
        $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, '__sleep', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;

        return array('valueHolder49a97');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer192cd = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer192cd;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer192cd && ($this->initializer192cd->__invoke($valueHolder49a97, $this, 'initializeProxy', array(), $this->initializer192cd) || 1) && $this->valueHolder49a97 = $valueHolder49a97;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder49a97;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder49a97;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
