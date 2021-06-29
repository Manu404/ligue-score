<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Gamedayruleset as ChildGamedayruleset;
use Model\GamedayrulesetQuery as ChildGamedayrulesetQuery;
use Model\Map\GamedayrulesetTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'gamedayruleset' table.
 *
 *
 *
 * @method     ChildGamedayrulesetQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGamedayrulesetQuery orderByRulesetid($order = Criteria::ASC) Order by the rulesetid column
 * @method     ChildGamedayrulesetQuery orderByDayid($order = Criteria::ASC) Order by the dayid column
 * @method     ChildGamedayrulesetQuery orderByGametypeid($order = Criteria::ASC) Order by the gametypeid column
 *
 * @method     ChildGamedayrulesetQuery groupById() Group by the id column
 * @method     ChildGamedayrulesetQuery groupByRulesetid() Group by the rulesetid column
 * @method     ChildGamedayrulesetQuery groupByDayid() Group by the dayid column
 * @method     ChildGamedayrulesetQuery groupByGametypeid() Group by the gametypeid column
 *
 * @method     ChildGamedayrulesetQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGamedayrulesetQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGamedayrulesetQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGamedayrulesetQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGamedayrulesetQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGamedayrulesetQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGamedayrulesetQuery leftJoinGameday($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gameday relation
 * @method     ChildGamedayrulesetQuery rightJoinGameday($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gameday relation
 * @method     ChildGamedayrulesetQuery innerJoinGameday($relationAlias = null) Adds a INNER JOIN clause to the query using the Gameday relation
 *
 * @method     ChildGamedayrulesetQuery joinWithGameday($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gameday relation
 *
 * @method     ChildGamedayrulesetQuery leftJoinWithGameday() Adds a LEFT JOIN clause and with to the query using the Gameday relation
 * @method     ChildGamedayrulesetQuery rightJoinWithGameday() Adds a RIGHT JOIN clause and with to the query using the Gameday relation
 * @method     ChildGamedayrulesetQuery innerJoinWithGameday() Adds a INNER JOIN clause and with to the query using the Gameday relation
 *
 * @method     ChildGamedayrulesetQuery leftJoinGametype($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gametype relation
 * @method     ChildGamedayrulesetQuery rightJoinGametype($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gametype relation
 * @method     ChildGamedayrulesetQuery innerJoinGametype($relationAlias = null) Adds a INNER JOIN clause to the query using the Gametype relation
 *
 * @method     ChildGamedayrulesetQuery joinWithGametype($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gametype relation
 *
 * @method     ChildGamedayrulesetQuery leftJoinWithGametype() Adds a LEFT JOIN clause and with to the query using the Gametype relation
 * @method     ChildGamedayrulesetQuery rightJoinWithGametype() Adds a RIGHT JOIN clause and with to the query using the Gametype relation
 * @method     ChildGamedayrulesetQuery innerJoinWithGametype() Adds a INNER JOIN clause and with to the query using the Gametype relation
 *
 * @method     ChildGamedayrulesetQuery leftJoinRuleset($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ruleset relation
 * @method     ChildGamedayrulesetQuery rightJoinRuleset($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ruleset relation
 * @method     ChildGamedayrulesetQuery innerJoinRuleset($relationAlias = null) Adds a INNER JOIN clause to the query using the Ruleset relation
 *
 * @method     ChildGamedayrulesetQuery joinWithRuleset($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Ruleset relation
 *
 * @method     ChildGamedayrulesetQuery leftJoinWithRuleset() Adds a LEFT JOIN clause and with to the query using the Ruleset relation
 * @method     ChildGamedayrulesetQuery rightJoinWithRuleset() Adds a RIGHT JOIN clause and with to the query using the Ruleset relation
 * @method     ChildGamedayrulesetQuery innerJoinWithRuleset() Adds a INNER JOIN clause and with to the query using the Ruleset relation
 *
 * @method     \Model\GamedayQuery|\Model\GametypeQuery|\Model\RulesetQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGamedayruleset|null findOne(ConnectionInterface $con = null) Return the first ChildGamedayruleset matching the query
 * @method     ChildGamedayruleset findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGamedayruleset matching the query, or a new ChildGamedayruleset object populated from the query conditions when no match is found
 *
 * @method     ChildGamedayruleset|null findOneById(int $id) Return the first ChildGamedayruleset filtered by the id column
 * @method     ChildGamedayruleset|null findOneByRulesetid(int $rulesetid) Return the first ChildGamedayruleset filtered by the rulesetid column
 * @method     ChildGamedayruleset|null findOneByDayid(int $dayid) Return the first ChildGamedayruleset filtered by the dayid column
 * @method     ChildGamedayruleset|null findOneByGametypeid(int $gametypeid) Return the first ChildGamedayruleset filtered by the gametypeid column *

 * @method     ChildGamedayruleset requirePk($key, ConnectionInterface $con = null) Return the ChildGamedayruleset by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamedayruleset requireOne(ConnectionInterface $con = null) Return the first ChildGamedayruleset matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGamedayruleset requireOneById(int $id) Return the first ChildGamedayruleset filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamedayruleset requireOneByRulesetid(int $rulesetid) Return the first ChildGamedayruleset filtered by the rulesetid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamedayruleset requireOneByDayid(int $dayid) Return the first ChildGamedayruleset filtered by the dayid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGamedayruleset requireOneByGametypeid(int $gametypeid) Return the first ChildGamedayruleset filtered by the gametypeid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGamedayruleset[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGamedayruleset objects based on current ModelCriteria
 * @method     ChildGamedayruleset[]|ObjectCollection findById(int $id) Return ChildGamedayruleset objects filtered by the id column
 * @method     ChildGamedayruleset[]|ObjectCollection findByRulesetid(int $rulesetid) Return ChildGamedayruleset objects filtered by the rulesetid column
 * @method     ChildGamedayruleset[]|ObjectCollection findByDayid(int $dayid) Return ChildGamedayruleset objects filtered by the dayid column
 * @method     ChildGamedayruleset[]|ObjectCollection findByGametypeid(int $gametypeid) Return ChildGamedayruleset objects filtered by the gametypeid column
 * @method     ChildGamedayruleset[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GamedayrulesetQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\GamedayrulesetQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Gamedayruleset', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGamedayrulesetQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGamedayrulesetQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGamedayrulesetQuery) {
            return $criteria;
        }
        $query = new ChildGamedayrulesetQuery();
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
     * @return ChildGamedayruleset|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GamedayrulesetTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GamedayrulesetTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGamedayruleset A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, rulesetid, dayid, gametypeid FROM gamedayruleset WHERE id = :p0';
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
            /** @var ChildGamedayruleset $obj */
            $obj = new ChildGamedayruleset();
            $obj->hydrate($row);
            GamedayrulesetTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGamedayruleset|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GamedayrulesetTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GamedayrulesetTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GamedayrulesetTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GamedayrulesetTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamedayrulesetTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the rulesetid column
     *
     * Example usage:
     * <code>
     * $query->filterByRulesetid(1234); // WHERE rulesetid = 1234
     * $query->filterByRulesetid(array(12, 34)); // WHERE rulesetid IN (12, 34)
     * $query->filterByRulesetid(array('min' => 12)); // WHERE rulesetid > 12
     * </code>
     *
     * @see       filterByRuleset()
     *
     * @param     mixed $rulesetid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterByRulesetid($rulesetid = null, $comparison = null)
    {
        if (is_array($rulesetid)) {
            $useMinMax = false;
            if (isset($rulesetid['min'])) {
                $this->addUsingAlias(GamedayrulesetTableMap::COL_RULESETID, $rulesetid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rulesetid['max'])) {
                $this->addUsingAlias(GamedayrulesetTableMap::COL_RULESETID, $rulesetid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamedayrulesetTableMap::COL_RULESETID, $rulesetid, $comparison);
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
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterByDayid($dayid = null, $comparison = null)
    {
        if (is_array($dayid)) {
            $useMinMax = false;
            if (isset($dayid['min'])) {
                $this->addUsingAlias(GamedayrulesetTableMap::COL_DAYID, $dayid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dayid['max'])) {
                $this->addUsingAlias(GamedayrulesetTableMap::COL_DAYID, $dayid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamedayrulesetTableMap::COL_DAYID, $dayid, $comparison);
    }

    /**
     * Filter the query on the gametypeid column
     *
     * Example usage:
     * <code>
     * $query->filterByGametypeid(1234); // WHERE gametypeid = 1234
     * $query->filterByGametypeid(array(12, 34)); // WHERE gametypeid IN (12, 34)
     * $query->filterByGametypeid(array('min' => 12)); // WHERE gametypeid > 12
     * </code>
     *
     * @see       filterByGametype()
     *
     * @param     mixed $gametypeid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterByGametypeid($gametypeid = null, $comparison = null)
    {
        if (is_array($gametypeid)) {
            $useMinMax = false;
            if (isset($gametypeid['min'])) {
                $this->addUsingAlias(GamedayrulesetTableMap::COL_GAMETYPEID, $gametypeid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gametypeid['max'])) {
                $this->addUsingAlias(GamedayrulesetTableMap::COL_GAMETYPEID, $gametypeid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamedayrulesetTableMap::COL_GAMETYPEID, $gametypeid, $comparison);
    }

    /**
     * Filter the query by a related \Model\Gameday object
     *
     * @param \Model\Gameday|ObjectCollection $gameday The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterByGameday($gameday, $comparison = null)
    {
        if ($gameday instanceof \Model\Gameday) {
            return $this
                ->addUsingAlias(GamedayrulesetTableMap::COL_DAYID, $gameday->getId(), $comparison);
        } elseif ($gameday instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamedayrulesetTableMap::COL_DAYID, $gameday->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
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
     * Filter the query by a related \Model\Gametype object
     *
     * @param \Model\Gametype|ObjectCollection $gametype The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterByGametype($gametype, $comparison = null)
    {
        if ($gametype instanceof \Model\Gametype) {
            return $this
                ->addUsingAlias(GamedayrulesetTableMap::COL_GAMETYPEID, $gametype->getId(), $comparison);
        } elseif ($gametype instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamedayrulesetTableMap::COL_GAMETYPEID, $gametype->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGametype() only accepts arguments of type \Model\Gametype or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gametype relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function joinGametype($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gametype');

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
            $this->addJoinObject($join, 'Gametype');
        }

        return $this;
    }

    /**
     * Use the Gametype relation Gametype object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GametypeQuery A secondary query class using the current class as primary query
     */
    public function useGametypeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGametype($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gametype', '\Model\GametypeQuery');
    }

    /**
     * Use the Gametype relation Gametype object
     *
     * @param callable(\Model\GametypeQuery):\Model\GametypeQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGametypeQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGametypeQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Gametype table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GametypeQuery The inner query object of the EXISTS statement
     */
    public function useGametypeExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gametype', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Gametype table for a NOT EXISTS query.
     *
     * @see useGametypeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GametypeQuery The inner query object of the NOT EXISTS statement
     */
    public function useGametypeNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gametype', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Ruleset object
     *
     * @param \Model\Ruleset|ObjectCollection $ruleset The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function filterByRuleset($ruleset, $comparison = null)
    {
        if ($ruleset instanceof \Model\Ruleset) {
            return $this
                ->addUsingAlias(GamedayrulesetTableMap::COL_RULESETID, $ruleset->getId(), $comparison);
        } elseif ($ruleset instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamedayrulesetTableMap::COL_RULESETID, $ruleset->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRuleset() only accepts arguments of type \Model\Ruleset or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Ruleset relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function joinRuleset($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Ruleset');

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
            $this->addJoinObject($join, 'Ruleset');
        }

        return $this;
    }

    /**
     * Use the Ruleset relation Ruleset object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\RulesetQuery A secondary query class using the current class as primary query
     */
    public function useRulesetQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRuleset($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Ruleset', '\Model\RulesetQuery');
    }

    /**
     * Use the Ruleset relation Ruleset object
     *
     * @param callable(\Model\RulesetQuery):\Model\RulesetQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withRulesetQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useRulesetQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Ruleset table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\RulesetQuery The inner query object of the EXISTS statement
     */
    public function useRulesetExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Ruleset', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Ruleset table for a NOT EXISTS query.
     *
     * @see useRulesetExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\RulesetQuery The inner query object of the NOT EXISTS statement
     */
    public function useRulesetNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Ruleset', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildGamedayruleset $gamedayruleset Object to remove from the list of results
     *
     * @return $this|ChildGamedayrulesetQuery The current query, for fluid interface
     */
    public function prune($gamedayruleset = null)
    {
        if ($gamedayruleset) {
            $this->addUsingAlias(GamedayrulesetTableMap::COL_ID, $gamedayruleset->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the gamedayruleset table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GamedayrulesetTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GamedayrulesetTableMap::clearInstancePool();
            GamedayrulesetTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GamedayrulesetTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GamedayrulesetTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GamedayrulesetTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GamedayrulesetTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GamedayrulesetQuery
