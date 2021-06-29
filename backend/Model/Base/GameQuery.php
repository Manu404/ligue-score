<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Game as ChildGame;
use Model\GameQuery as ChildGameQuery;
use Model\Map\GameTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'game' table.
 *
 *
 *
 * @method     ChildGameQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGameQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildGameQuery orderByDayid($order = Criteria::ASC) Order by the dayid column
 *
 * @method     ChildGameQuery groupById() Group by the id column
 * @method     ChildGameQuery groupByType() Group by the type column
 * @method     ChildGameQuery groupByDayid() Group by the dayid column
 *
 * @method     ChildGameQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGameQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGameQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGameQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGameQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGameQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGameQuery leftJoinGameday($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gameday relation
 * @method     ChildGameQuery rightJoinGameday($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gameday relation
 * @method     ChildGameQuery innerJoinGameday($relationAlias = null) Adds a INNER JOIN clause to the query using the Gameday relation
 *
 * @method     ChildGameQuery joinWithGameday($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gameday relation
 *
 * @method     ChildGameQuery leftJoinWithGameday() Adds a LEFT JOIN clause and with to the query using the Gameday relation
 * @method     ChildGameQuery rightJoinWithGameday() Adds a RIGHT JOIN clause and with to the query using the Gameday relation
 * @method     ChildGameQuery innerJoinWithGameday() Adds a INNER JOIN clause and with to the query using the Gameday relation
 *
 * @method     ChildGameQuery leftJoinGameplayers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gameplayers relation
 * @method     ChildGameQuery rightJoinGameplayers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gameplayers relation
 * @method     ChildGameQuery innerJoinGameplayers($relationAlias = null) Adds a INNER JOIN clause to the query using the Gameplayers relation
 *
 * @method     ChildGameQuery joinWithGameplayers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gameplayers relation
 *
 * @method     ChildGameQuery leftJoinWithGameplayers() Adds a LEFT JOIN clause and with to the query using the Gameplayers relation
 * @method     ChildGameQuery rightJoinWithGameplayers() Adds a RIGHT JOIN clause and with to the query using the Gameplayers relation
 * @method     ChildGameQuery innerJoinWithGameplayers() Adds a INNER JOIN clause and with to the query using the Gameplayers relation
 *
 * @method     ChildGameQuery leftJoinGamescore($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gamescore relation
 * @method     ChildGameQuery rightJoinGamescore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gamescore relation
 * @method     ChildGameQuery innerJoinGamescore($relationAlias = null) Adds a INNER JOIN clause to the query using the Gamescore relation
 *
 * @method     ChildGameQuery joinWithGamescore($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gamescore relation
 *
 * @method     ChildGameQuery leftJoinWithGamescore() Adds a LEFT JOIN clause and with to the query using the Gamescore relation
 * @method     ChildGameQuery rightJoinWithGamescore() Adds a RIGHT JOIN clause and with to the query using the Gamescore relation
 * @method     ChildGameQuery innerJoinWithGamescore() Adds a INNER JOIN clause and with to the query using the Gamescore relation
 *
 * @method     ChildGameQuery leftJoinPlayerBuy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerBuy relation
 * @method     ChildGameQuery rightJoinPlayerBuy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerBuy relation
 * @method     ChildGameQuery innerJoinPlayerBuy($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerBuy relation
 *
 * @method     ChildGameQuery joinWithPlayerBuy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PlayerBuy relation
 *
 * @method     ChildGameQuery leftJoinWithPlayerBuy() Adds a LEFT JOIN clause and with to the query using the PlayerBuy relation
 * @method     ChildGameQuery rightJoinWithPlayerBuy() Adds a RIGHT JOIN clause and with to the query using the PlayerBuy relation
 * @method     ChildGameQuery innerJoinWithPlayerBuy() Adds a INNER JOIN clause and with to the query using the PlayerBuy relation
 *
 * @method     ChildGameQuery leftJoinTransactions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Transactions relation
 * @method     ChildGameQuery rightJoinTransactions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Transactions relation
 * @method     ChildGameQuery innerJoinTransactions($relationAlias = null) Adds a INNER JOIN clause to the query using the Transactions relation
 *
 * @method     ChildGameQuery joinWithTransactions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Transactions relation
 *
 * @method     ChildGameQuery leftJoinWithTransactions() Adds a LEFT JOIN clause and with to the query using the Transactions relation
 * @method     ChildGameQuery rightJoinWithTransactions() Adds a RIGHT JOIN clause and with to the query using the Transactions relation
 * @method     ChildGameQuery innerJoinWithTransactions() Adds a INNER JOIN clause and with to the query using the Transactions relation
 *
 * @method     \Model\GamedayQuery|\Model\GameplayersQuery|\Model\GamescoreQuery|\Model\PlayerBuyQuery|\Model\TransactionsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGame|null findOne(ConnectionInterface $con = null) Return the first ChildGame matching the query
 * @method     ChildGame findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGame matching the query, or a new ChildGame object populated from the query conditions when no match is found
 *
 * @method     ChildGame|null findOneById(int $id) Return the first ChildGame filtered by the id column
 * @method     ChildGame|null findOneByType(int $type) Return the first ChildGame filtered by the type column
 * @method     ChildGame|null findOneByDayid(int $dayid) Return the first ChildGame filtered by the dayid column *

 * @method     ChildGame requirePk($key, ConnectionInterface $con = null) Return the ChildGame by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOne(ConnectionInterface $con = null) Return the first ChildGame matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGame requireOneById(int $id) Return the first ChildGame filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOneByType(int $type) Return the first ChildGame filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGame requireOneByDayid(int $dayid) Return the first ChildGame filtered by the dayid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGame[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGame objects based on current ModelCriteria
 * @method     ChildGame[]|ObjectCollection findById(int $id) Return ChildGame objects filtered by the id column
 * @method     ChildGame[]|ObjectCollection findByType(int $type) Return ChildGame objects filtered by the type column
 * @method     ChildGame[]|ObjectCollection findByDayid(int $dayid) Return ChildGame objects filtered by the dayid column
 * @method     ChildGame[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GameQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\GameQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Game', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGameQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGameQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGameQuery) {
            return $criteria;
        }
        $query = new ChildGameQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildGame|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GameTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGame A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, type, dayid FROM game WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildGame $obj */
            $obj = new ChildGame();
            $obj->hydrate($row);
            GameTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildGame|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GameTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GameTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GameTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GameTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType(1234); // WHERE type = 1234
     * $query->filterByType(array(12, 34)); // WHERE type IN (12, 34)
     * $query->filterByType(array('min' => 12)); // WHERE type > 12
     * </code>
     *
     * @param     mixed $type The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(GameTableMap::COL_TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(GameTableMap::COL_TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the dayid column
     *
     * Example usage:
     * <code>
     * $query->filterByDayid(1234); // WHERE dayid = 1234
     * $query->filterByDayid(array(12, 34)); // WHERE dayid IN (12, 34)
     * $query->filterByDayid(array('min' => 12)); // WHERE dayid > 12
     * </code>
     *
     * @see       filterByGameday()
     *
     * @param     mixed $dayid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function filterByDayid($dayid = null, $comparison = null)
    {
        if (is_array($dayid)) {
            $useMinMax = false;
            if (isset($dayid['min'])) {
                $this->addUsingAlias(GameTableMap::COL_DAYID, $dayid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dayid['max'])) {
                $this->addUsingAlias(GameTableMap::COL_DAYID, $dayid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GameTableMap::COL_DAYID, $dayid, $comparison);
    }

    /**
     * Filter the query by a related \Model\Gameday object
     *
     * @param \Model\Gameday|ObjectCollection $gameday The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByGameday($gameday, $comparison = null)
    {
        if ($gameday instanceof \Model\Gameday) {
            return $this
                ->addUsingAlias(GameTableMap::COL_DAYID, $gameday->getId(), $comparison);
        } elseif ($gameday instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GameTableMap::COL_DAYID, $gameday->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGameday() only accepts arguments of type \Model\Gameday or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gameday relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinGameday($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gameday');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Gameday');
        }

        return $this;
    }

    /**
     * Use the Gameday relation Gameday object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GamedayQuery A secondary query class using the current class as primary query
     */
    public function useGamedayQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGameday($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gameday', '\Model\GamedayQuery');
    }

    /**
     * Use the Gameday relation Gameday object
     *
     * @param callable(\Model\GamedayQuery):\Model\GamedayQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGamedayQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGamedayQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Gameday table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GamedayQuery The inner query object of the EXISTS statement
     */
    public function useGamedayExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gameday', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Gameday table for a NOT EXISTS query.
     *
     * @see useGamedayExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GamedayQuery The inner query object of the NOT EXISTS statement
     */
    public function useGamedayNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gameday', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Gameplayers object
     *
     * @param \Model\Gameplayers|ObjectCollection $gameplayers the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByGameplayers($gameplayers, $comparison = null)
    {
        if ($gameplayers instanceof \Model\Gameplayers) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $gameplayers->getGameid(), $comparison);
        } elseif ($gameplayers instanceof ObjectCollection) {
            return $this
                ->useGameplayersQuery()
                ->filterByPrimaryKeys($gameplayers->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGameplayers() only accepts arguments of type \Model\Gameplayers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gameplayers relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinGameplayers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gameplayers');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Gameplayers');
        }

        return $this;
    }

    /**
     * Use the Gameplayers relation Gameplayers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GameplayersQuery A secondary query class using the current class as primary query
     */
    public function useGameplayersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGameplayers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gameplayers', '\Model\GameplayersQuery');
    }

    /**
     * Use the Gameplayers relation Gameplayers object
     *
     * @param callable(\Model\GameplayersQuery):\Model\GameplayersQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGameplayersQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGameplayersQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Gameplayers table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GameplayersQuery The inner query object of the EXISTS statement
     */
    public function useGameplayersExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gameplayers', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Gameplayers table for a NOT EXISTS query.
     *
     * @see useGameplayersExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GameplayersQuery The inner query object of the NOT EXISTS statement
     */
    public function useGameplayersNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gameplayers', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Gamescore object
     *
     * @param \Model\Gamescore|ObjectCollection $gamescore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByGamescore($gamescore, $comparison = null)
    {
        if ($gamescore instanceof \Model\Gamescore) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $gamescore->getGameid(), $comparison);
        } elseif ($gamescore instanceof ObjectCollection) {
            return $this
                ->useGamescoreQuery()
                ->filterByPrimaryKeys($gamescore->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGamescore() only accepts arguments of type \Model\Gamescore or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gamescore relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinGamescore($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gamescore');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Gamescore');
        }

        return $this;
    }

    /**
     * Use the Gamescore relation Gamescore object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GamescoreQuery A secondary query class using the current class as primary query
     */
    public function useGamescoreQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGamescore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gamescore', '\Model\GamescoreQuery');
    }

    /**
     * Use the Gamescore relation Gamescore object
     *
     * @param callable(\Model\GamescoreQuery):\Model\GamescoreQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGamescoreQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGamescoreQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Gamescore table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GamescoreQuery The inner query object of the EXISTS statement
     */
    public function useGamescoreExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gamescore', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Gamescore table for a NOT EXISTS query.
     *
     * @see useGamescoreExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GamescoreQuery The inner query object of the NOT EXISTS statement
     */
    public function useGamescoreNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gamescore', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\PlayerBuy object
     *
     * @param \Model\PlayerBuy|ObjectCollection $playerBuy the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByPlayerBuy($playerBuy, $comparison = null)
    {
        if ($playerBuy instanceof \Model\PlayerBuy) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $playerBuy->getGameid(), $comparison);
        } elseif ($playerBuy instanceof ObjectCollection) {
            return $this
                ->usePlayerBuyQuery()
                ->filterByPrimaryKeys($playerBuy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlayerBuy() only accepts arguments of type \Model\PlayerBuy or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerBuy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinPlayerBuy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerBuy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PlayerBuy');
        }

        return $this;
    }

    /**
     * Use the PlayerBuy relation PlayerBuy object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\PlayerBuyQuery A secondary query class using the current class as primary query
     */
    public function usePlayerBuyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlayerBuy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerBuy', '\Model\PlayerBuyQuery');
    }

    /**
     * Use the PlayerBuy relation PlayerBuy object
     *
     * @param callable(\Model\PlayerBuyQuery):\Model\PlayerBuyQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPlayerBuyQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->usePlayerBuyQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to PlayerBuy table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\PlayerBuyQuery The inner query object of the EXISTS statement
     */
    public function usePlayerBuyExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('PlayerBuy', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to PlayerBuy table for a NOT EXISTS query.
     *
     * @see usePlayerBuyExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\PlayerBuyQuery The inner query object of the NOT EXISTS statement
     */
    public function usePlayerBuyNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('PlayerBuy', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Transactions object
     *
     * @param \Model\Transactions|ObjectCollection $transactions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGameQuery The current query, for fluid interface
     */
    public function filterByTransactions($transactions, $comparison = null)
    {
        if ($transactions instanceof \Model\Transactions) {
            return $this
                ->addUsingAlias(GameTableMap::COL_ID, $transactions->getGameid(), $comparison);
        } elseif ($transactions instanceof ObjectCollection) {
            return $this
                ->useTransactionsQuery()
                ->filterByPrimaryKeys($transactions->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTransactions() only accepts arguments of type \Model\Transactions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Transactions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function joinTransactions($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Transactions');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Transactions');
        }

        return $this;
    }

    /**
     * Use the Transactions relation Transactions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\TransactionsQuery A secondary query class using the current class as primary query
     */
    public function useTransactionsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTransactions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Transactions', '\Model\TransactionsQuery');
    }

    /**
     * Use the Transactions relation Transactions object
     *
     * @param callable(\Model\TransactionsQuery):\Model\TransactionsQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withTransactionsQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useTransactionsQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Transactions table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\TransactionsQuery The inner query object of the EXISTS statement
     */
    public function useTransactionsExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Transactions', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Transactions table for a NOT EXISTS query.
     *
     * @see useTransactionsExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\TransactionsQuery The inner query object of the NOT EXISTS statement
     */
    public function useTransactionsNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Transactions', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildGame $game Object to remove from the list of results
     *
     * @return $this|ChildGameQuery The current query, for fluid interface
     */
    public function prune($game = null)
    {
        if ($game) {
            $this->addUsingAlias(GameTableMap::COL_ID, $game->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the game table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GameTableMap::clearInstancePool();
            GameTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GameTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GameTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GameTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GameQuery
