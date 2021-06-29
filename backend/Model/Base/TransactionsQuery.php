<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Transactions as ChildTransactions;
use Model\TransactionsQuery as ChildTransactionsQuery;
use Model\Map\TransactionsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'transactions' table.
 *
 *
 *
 * @method     ChildTransactionsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTransactionsQuery orderBySourceid($order = Criteria::ASC) Order by the sourceid column
 * @method     ChildTransactionsQuery orderByTargetid($order = Criteria::ASC) Order by the targetid column
 * @method     ChildTransactionsQuery orderByDelta($order = Criteria::ASC) Order by the delta column
 * @method     ChildTransactionsQuery orderByGameid($order = Criteria::ASC) Order by the gameid column
 *
 * @method     ChildTransactionsQuery groupById() Group by the id column
 * @method     ChildTransactionsQuery groupBySourceid() Group by the sourceid column
 * @method     ChildTransactionsQuery groupByTargetid() Group by the targetid column
 * @method     ChildTransactionsQuery groupByDelta() Group by the delta column
 * @method     ChildTransactionsQuery groupByGameid() Group by the gameid column
 *
 * @method     ChildTransactionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTransactionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTransactionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTransactionsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTransactionsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTransactionsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTransactionsQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method     ChildTransactionsQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method     ChildTransactionsQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method     ChildTransactionsQuery joinWithGame($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Game relation
 *
 * @method     ChildTransactionsQuery leftJoinWithGame() Adds a LEFT JOIN clause and with to the query using the Game relation
 * @method     ChildTransactionsQuery rightJoinWithGame() Adds a RIGHT JOIN clause and with to the query using the Game relation
 * @method     ChildTransactionsQuery innerJoinWithGame() Adds a INNER JOIN clause and with to the query using the Game relation
 *
 * @method     ChildTransactionsQuery leftJoinPlayerRelatedBySourceid($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerRelatedBySourceid relation
 * @method     ChildTransactionsQuery rightJoinPlayerRelatedBySourceid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerRelatedBySourceid relation
 * @method     ChildTransactionsQuery innerJoinPlayerRelatedBySourceid($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerRelatedBySourceid relation
 *
 * @method     ChildTransactionsQuery joinWithPlayerRelatedBySourceid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PlayerRelatedBySourceid relation
 *
 * @method     ChildTransactionsQuery leftJoinWithPlayerRelatedBySourceid() Adds a LEFT JOIN clause and with to the query using the PlayerRelatedBySourceid relation
 * @method     ChildTransactionsQuery rightJoinWithPlayerRelatedBySourceid() Adds a RIGHT JOIN clause and with to the query using the PlayerRelatedBySourceid relation
 * @method     ChildTransactionsQuery innerJoinWithPlayerRelatedBySourceid() Adds a INNER JOIN clause and with to the query using the PlayerRelatedBySourceid relation
 *
 * @method     ChildTransactionsQuery leftJoinPlayerRelatedByTargetid($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerRelatedByTargetid relation
 * @method     ChildTransactionsQuery rightJoinPlayerRelatedByTargetid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerRelatedByTargetid relation
 * @method     ChildTransactionsQuery innerJoinPlayerRelatedByTargetid($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerRelatedByTargetid relation
 *
 * @method     ChildTransactionsQuery joinWithPlayerRelatedByTargetid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PlayerRelatedByTargetid relation
 *
 * @method     ChildTransactionsQuery leftJoinWithPlayerRelatedByTargetid() Adds a LEFT JOIN clause and with to the query using the PlayerRelatedByTargetid relation
 * @method     ChildTransactionsQuery rightJoinWithPlayerRelatedByTargetid() Adds a RIGHT JOIN clause and with to the query using the PlayerRelatedByTargetid relation
 * @method     ChildTransactionsQuery innerJoinWithPlayerRelatedByTargetid() Adds a INNER JOIN clause and with to the query using the PlayerRelatedByTargetid relation
 *
 * @method     \Model\GameQuery|\Model\PlayerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTransactions|null findOne(ConnectionInterface $con = null) Return the first ChildTransactions matching the query
 * @method     ChildTransactions findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTransactions matching the query, or a new ChildTransactions object populated from the query conditions when no match is found
 *
 * @method     ChildTransactions|null findOneById(int $id) Return the first ChildTransactions filtered by the id column
 * @method     ChildTransactions|null findOneBySourceid(int $sourceid) Return the first ChildTransactions filtered by the sourceid column
 * @method     ChildTransactions|null findOneByTargetid(int $targetid) Return the first ChildTransactions filtered by the targetid column
 * @method     ChildTransactions|null findOneByDelta(int $delta) Return the first ChildTransactions filtered by the delta column
 * @method     ChildTransactions|null findOneByGameid(int $gameid) Return the first ChildTransactions filtered by the gameid column *

 * @method     ChildTransactions requirePk($key, ConnectionInterface $con = null) Return the ChildTransactions by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransactions requireOne(ConnectionInterface $con = null) Return the first ChildTransactions matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTransactions requireOneById(int $id) Return the first ChildTransactions filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransactions requireOneBySourceid(int $sourceid) Return the first ChildTransactions filtered by the sourceid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransactions requireOneByTargetid(int $targetid) Return the first ChildTransactions filtered by the targetid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransactions requireOneByDelta(int $delta) Return the first ChildTransactions filtered by the delta column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransactions requireOneByGameid(int $gameid) Return the first ChildTransactions filtered by the gameid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTransactions[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTransactions objects based on current ModelCriteria
 * @method     ChildTransactions[]|ObjectCollection findById(int $id) Return ChildTransactions objects filtered by the id column
 * @method     ChildTransactions[]|ObjectCollection findBySourceid(int $sourceid) Return ChildTransactions objects filtered by the sourceid column
 * @method     ChildTransactions[]|ObjectCollection findByTargetid(int $targetid) Return ChildTransactions objects filtered by the targetid column
 * @method     ChildTransactions[]|ObjectCollection findByDelta(int $delta) Return ChildTransactions objects filtered by the delta column
 * @method     ChildTransactions[]|ObjectCollection findByGameid(int $gameid) Return ChildTransactions objects filtered by the gameid column
 * @method     ChildTransactions[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TransactionsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\TransactionsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Transactions', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTransactionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTransactionsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTransactionsQuery) {
            return $criteria;
        }
        $query = new ChildTransactionsQuery();
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
     * @return ChildTransactions|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TransactionsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TransactionsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTransactions A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, sourceid, targetid, delta, gameid FROM transactions WHERE id = :p0';
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
            /** @var ChildTransactions $obj */
            $obj = new ChildTransactions();
            $obj->hydrate($row);
            TransactionsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTransactions|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TransactionsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TransactionsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the sourceid column
     *
     * Example usage:
     * <code>
     * $query->filterBySourceid(1234); // WHERE sourceid = 1234
     * $query->filterBySourceid(array(12, 34)); // WHERE sourceid IN (12, 34)
     * $query->filterBySourceid(array('min' => 12)); // WHERE sourceid > 12
     * </code>
     *
     * @see       filterByPlayerRelatedBySourceid()
     *
     * @param     mixed $sourceid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterBySourceid($sourceid = null, $comparison = null)
    {
        if (is_array($sourceid)) {
            $useMinMax = false;
            if (isset($sourceid['min'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_SOURCEID, $sourceid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sourceid['max'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_SOURCEID, $sourceid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsTableMap::COL_SOURCEID, $sourceid, $comparison);
    }

    /**
     * Filter the query on the targetid column
     *
     * Example usage:
     * <code>
     * $query->filterByTargetid(1234); // WHERE targetid = 1234
     * $query->filterByTargetid(array(12, 34)); // WHERE targetid IN (12, 34)
     * $query->filterByTargetid(array('min' => 12)); // WHERE targetid > 12
     * </code>
     *
     * @see       filterByPlayerRelatedByTargetid()
     *
     * @param     mixed $targetid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterByTargetid($targetid = null, $comparison = null)
    {
        if (is_array($targetid)) {
            $useMinMax = false;
            if (isset($targetid['min'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_TARGETID, $targetid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetid['max'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_TARGETID, $targetid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsTableMap::COL_TARGETID, $targetid, $comparison);
    }

    /**
     * Filter the query on the delta column
     *
     * Example usage:
     * <code>
     * $query->filterByDelta(1234); // WHERE delta = 1234
     * $query->filterByDelta(array(12, 34)); // WHERE delta IN (12, 34)
     * $query->filterByDelta(array('min' => 12)); // WHERE delta > 12
     * </code>
     *
     * @param     mixed $delta The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterByDelta($delta = null, $comparison = null)
    {
        if (is_array($delta)) {
            $useMinMax = false;
            if (isset($delta['min'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_DELTA, $delta['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($delta['max'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_DELTA, $delta['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsTableMap::COL_DELTA, $delta, $comparison);
    }

    /**
     * Filter the query on the gameid column
     *
     * Example usage:
     * <code>
     * $query->filterByGameid(1234); // WHERE gameid = 1234
     * $query->filterByGameid(array(12, 34)); // WHERE gameid IN (12, 34)
     * $query->filterByGameid(array('min' => 12)); // WHERE gameid > 12
     * </code>
     *
     * @see       filterByGame()
     *
     * @param     mixed $gameid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterByGameid($gameid = null, $comparison = null)
    {
        if (is_array($gameid)) {
            $useMinMax = false;
            if (isset($gameid['min'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_GAMEID, $gameid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameid['max'])) {
                $this->addUsingAlias(TransactionsTableMap::COL_GAMEID, $gameid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsTableMap::COL_GAMEID, $gameid, $comparison);
    }

    /**
     * Filter the query by a related \Model\Game object
     *
     * @param \Model\Game|ObjectCollection $game The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterByGame($game, $comparison = null)
    {
        if ($game instanceof \Model\Game) {
            return $this
                ->addUsingAlias(TransactionsTableMap::COL_GAMEID, $game->getId(), $comparison);
        } elseif ($game instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionsTableMap::COL_GAMEID, $game->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGame() only accepts arguments of type \Model\Game or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Game relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function joinGame($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Game');

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
            $this->addJoinObject($join, 'Game');
        }

        return $this;
    }

    /**
     * Use the Game relation Game object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GameQuery A secondary query class using the current class as primary query
     */
    public function useGameQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGame($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Game', '\Model\GameQuery');
    }

    /**
     * Use the Game relation Game object
     *
     * @param callable(\Model\GameQuery):\Model\GameQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGameQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGameQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Game table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GameQuery The inner query object of the EXISTS statement
     */
    public function useGameExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Game', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Game table for a NOT EXISTS query.
     *
     * @see useGameExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GameQuery The inner query object of the NOT EXISTS statement
     */
    public function useGameNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Game', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Player object
     *
     * @param \Model\Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterByPlayerRelatedBySourceid($player, $comparison = null)
    {
        if ($player instanceof \Model\Player) {
            return $this
                ->addUsingAlias(TransactionsTableMap::COL_SOURCEID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionsTableMap::COL_SOURCEID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPlayerRelatedBySourceid() only accepts arguments of type \Model\Player or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerRelatedBySourceid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function joinPlayerRelatedBySourceid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerRelatedBySourceid');

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
            $this->addJoinObject($join, 'PlayerRelatedBySourceid');
        }

        return $this;
    }

    /**
     * Use the PlayerRelatedBySourceid relation Player object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\PlayerQuery A secondary query class using the current class as primary query
     */
    public function usePlayerRelatedBySourceidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlayerRelatedBySourceid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerRelatedBySourceid', '\Model\PlayerQuery');
    }

    /**
     * Use the PlayerRelatedBySourceid relation Player object
     *
     * @param callable(\Model\PlayerQuery):\Model\PlayerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPlayerRelatedBySourceidQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->usePlayerRelatedBySourceidQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the PlayerRelatedBySourceid relation to the Player table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\PlayerQuery The inner query object of the EXISTS statement
     */
    public function usePlayerRelatedBySourceidExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('PlayerRelatedBySourceid', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the PlayerRelatedBySourceid relation to the Player table for a NOT EXISTS query.
     *
     * @see usePlayerRelatedBySourceidExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\PlayerQuery The inner query object of the NOT EXISTS statement
     */
    public function usePlayerRelatedBySourceidNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('PlayerRelatedBySourceid', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Player object
     *
     * @param \Model\Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransactionsQuery The current query, for fluid interface
     */
    public function filterByPlayerRelatedByTargetid($player, $comparison = null)
    {
        if ($player instanceof \Model\Player) {
            return $this
                ->addUsingAlias(TransactionsTableMap::COL_TARGETID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionsTableMap::COL_TARGETID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPlayerRelatedByTargetid() only accepts arguments of type \Model\Player or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerRelatedByTargetid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function joinPlayerRelatedByTargetid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerRelatedByTargetid');

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
            $this->addJoinObject($join, 'PlayerRelatedByTargetid');
        }

        return $this;
    }

    /**
     * Use the PlayerRelatedByTargetid relation Player object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\PlayerQuery A secondary query class using the current class as primary query
     */
    public function usePlayerRelatedByTargetidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlayerRelatedByTargetid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerRelatedByTargetid', '\Model\PlayerQuery');
    }

    /**
     * Use the PlayerRelatedByTargetid relation Player object
     *
     * @param callable(\Model\PlayerQuery):\Model\PlayerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPlayerRelatedByTargetidQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->usePlayerRelatedByTargetidQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the PlayerRelatedByTargetid relation to the Player table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\PlayerQuery The inner query object of the EXISTS statement
     */
    public function usePlayerRelatedByTargetidExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('PlayerRelatedByTargetid', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the PlayerRelatedByTargetid relation to the Player table for a NOT EXISTS query.
     *
     * @see usePlayerRelatedByTargetidExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\PlayerQuery The inner query object of the NOT EXISTS statement
     */
    public function usePlayerRelatedByTargetidNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('PlayerRelatedByTargetid', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildTransactions $transactions Object to remove from the list of results
     *
     * @return $this|ChildTransactionsQuery The current query, for fluid interface
     */
    public function prune($transactions = null)
    {
        if ($transactions) {
            $this->addUsingAlias(TransactionsTableMap::COL_ID, $transactions->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the transactions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TransactionsTableMap::clearInstancePool();
            TransactionsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TransactionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TransactionsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TransactionsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TransactionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TransactionsQuery
