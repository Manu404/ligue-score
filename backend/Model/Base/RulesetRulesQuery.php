<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\RulesetRules as ChildRulesetRules;
use Model\RulesetRulesQuery as ChildRulesetRulesQuery;
use Model\Map\RulesetRulesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ruleset_rules' table.
 *
 *
 *
 * @method     ChildRulesetRulesQuery orderByRulesetid($order = Criteria::ASC) Order by the rulesetid column
 * @method     ChildRulesetRulesQuery orderByRuleid($order = Criteria::ASC) Order by the ruleid column
 *
 * @method     ChildRulesetRulesQuery groupByRulesetid() Group by the rulesetid column
 * @method     ChildRulesetRulesQuery groupByRuleid() Group by the ruleid column
 *
 * @method     ChildRulesetRulesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRulesetRulesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRulesetRulesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRulesetRulesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRulesetRulesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRulesetRulesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRulesetRulesQuery leftJoinRules($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rules relation
 * @method     ChildRulesetRulesQuery rightJoinRules($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rules relation
 * @method     ChildRulesetRulesQuery innerJoinRules($relationAlias = null) Adds a INNER JOIN clause to the query using the Rules relation
 *
 * @method     ChildRulesetRulesQuery joinWithRules($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Rules relation
 *
 * @method     ChildRulesetRulesQuery leftJoinWithRules() Adds a LEFT JOIN clause and with to the query using the Rules relation
 * @method     ChildRulesetRulesQuery rightJoinWithRules() Adds a RIGHT JOIN clause and with to the query using the Rules relation
 * @method     ChildRulesetRulesQuery innerJoinWithRules() Adds a INNER JOIN clause and with to the query using the Rules relation
 *
 * @method     ChildRulesetRulesQuery leftJoinRuleset($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ruleset relation
 * @method     ChildRulesetRulesQuery rightJoinRuleset($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ruleset relation
 * @method     ChildRulesetRulesQuery innerJoinRuleset($relationAlias = null) Adds a INNER JOIN clause to the query using the Ruleset relation
 *
 * @method     ChildRulesetRulesQuery joinWithRuleset($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Ruleset relation
 *
 * @method     ChildRulesetRulesQuery leftJoinWithRuleset() Adds a LEFT JOIN clause and with to the query using the Ruleset relation
 * @method     ChildRulesetRulesQuery rightJoinWithRuleset() Adds a RIGHT JOIN clause and with to the query using the Ruleset relation
 * @method     ChildRulesetRulesQuery innerJoinWithRuleset() Adds a INNER JOIN clause and with to the query using the Ruleset relation
 *
 * @method     \Model\RulesQuery|\Model\RulesetQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRulesetRules|null findOne(ConnectionInterface $con = null) Return the first ChildRulesetRules matching the query
 * @method     ChildRulesetRules findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRulesetRules matching the query, or a new ChildRulesetRules object populated from the query conditions when no match is found
 *
 * @method     ChildRulesetRules|null findOneByRulesetid(int $rulesetid) Return the first ChildRulesetRules filtered by the rulesetid column
 * @method     ChildRulesetRules|null findOneByRuleid(int $ruleid) Return the first ChildRulesetRules filtered by the ruleid column *

 * @method     ChildRulesetRules requirePk($key, ConnectionInterface $con = null) Return the ChildRulesetRules by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetRules requireOne(ConnectionInterface $con = null) Return the first ChildRulesetRules matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetRules requireOneByRulesetid(int $rulesetid) Return the first ChildRulesetRules filtered by the rulesetid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRulesetRules requireOneByRuleid(int $ruleid) Return the first ChildRulesetRules filtered by the ruleid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRulesetRules[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRulesetRules objects based on current ModelCriteria
 * @method     ChildRulesetRules[]|ObjectCollection findByRulesetid(int $rulesetid) Return ChildRulesetRules objects filtered by the rulesetid column
 * @method     ChildRulesetRules[]|ObjectCollection findByRuleid(int $ruleid) Return ChildRulesetRules objects filtered by the ruleid column
 * @method     ChildRulesetRules[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RulesetRulesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\RulesetRulesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\RulesetRules', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRulesetRulesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRulesetRulesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRulesetRulesQuery) {
            return $criteria;
        }
        $query = new ChildRulesetRulesQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$rulesetid, $ruleid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRulesetRules|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RulesetRulesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RulesetRulesTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRulesetRules A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT rulesetid, ruleid FROM ruleset_rules WHERE rulesetid = :p0 AND ruleid = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRulesetRules $obj */
            $obj = new ChildRulesetRules();
            $obj->hydrate($row);
            RulesetRulesTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRulesetRules|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RulesetRulesTableMap::COL_RULESETID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RulesetRulesTableMap::COL_RULEID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RulesetRulesTableMap::COL_RULESETID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RulesetRulesTableMap::COL_RULEID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function filterByRulesetid($rulesetid = null, $comparison = null)
    {
        if (is_array($rulesetid)) {
            $useMinMax = false;
            if (isset($rulesetid['min'])) {
                $this->addUsingAlias(RulesetRulesTableMap::COL_RULESETID, $rulesetid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rulesetid['max'])) {
                $this->addUsingAlias(RulesetRulesTableMap::COL_RULESETID, $rulesetid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetRulesTableMap::COL_RULESETID, $rulesetid, $comparison);
    }

    /**
     * Filter the query on the ruleid column
     *
     * Example usage:
     * <code>
     * $query->filterByRuleid(1234); // WHERE ruleid = 1234
     * $query->filterByRuleid(array(12, 34)); // WHERE ruleid IN (12, 34)
     * $query->filterByRuleid(array('min' => 12)); // WHERE ruleid > 12
     * </code>
     *
     * @see       filterByRules()
     *
     * @param     mixed $ruleid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function filterByRuleid($ruleid = null, $comparison = null)
    {
        if (is_array($ruleid)) {
            $useMinMax = false;
            if (isset($ruleid['min'])) {
                $this->addUsingAlias(RulesetRulesTableMap::COL_RULEID, $ruleid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ruleid['max'])) {
                $this->addUsingAlias(RulesetRulesTableMap::COL_RULEID, $ruleid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RulesetRulesTableMap::COL_RULEID, $ruleid, $comparison);
    }

    /**
     * Filter the query by a related \Model\Rules object
     *
     * @param \Model\Rules|ObjectCollection $rules The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function filterByRules($rules, $comparison = null)
    {
        if ($rules instanceof \Model\Rules) {
            return $this
                ->addUsingAlias(RulesetRulesTableMap::COL_RULEID, $rules->getId(), $comparison);
        } elseif ($rules instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetRulesTableMap::COL_RULEID, $rules->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRules() only accepts arguments of type \Model\Rules or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Rules relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function joinRules($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Rules');

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
            $this->addJoinObject($join, 'Rules');
        }

        return $this;
    }

    /**
     * Use the Rules relation Rules object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\RulesQuery A secondary query class using the current class as primary query
     */
    public function useRulesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRules($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Rules', '\Model\RulesQuery');
    }

    /**
     * Use the Rules relation Rules object
     *
     * @param callable(\Model\RulesQuery):\Model\RulesQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withRulesQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useRulesQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Rules table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\RulesQuery The inner query object of the EXISTS statement
     */
    public function useRulesExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Rules', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Rules table for a NOT EXISTS query.
     *
     * @see useRulesExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\RulesQuery The inner query object of the NOT EXISTS statement
     */
    public function useRulesNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Rules', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Ruleset object
     *
     * @param \Model\Ruleset|ObjectCollection $ruleset The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function filterByRuleset($ruleset, $comparison = null)
    {
        if ($ruleset instanceof \Model\Ruleset) {
            return $this
                ->addUsingAlias(RulesetRulesTableMap::COL_RULESETID, $ruleset->getId(), $comparison);
        } elseif ($ruleset instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RulesetRulesTableMap::COL_RULESETID, $ruleset->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function joinRuleset($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useRulesetQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
        ?string $joinType = Criteria::INNER_JOIN
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
     * @param   ChildRulesetRules $rulesetRules Object to remove from the list of results
     *
     * @return $this|ChildRulesetRulesQuery The current query, for fluid interface
     */
    public function prune($rulesetRules = null)
    {
        if ($rulesetRules) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RulesetRulesTableMap::COL_RULESETID), $rulesetRules->getRulesetid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RulesetRulesTableMap::COL_RULEID), $rulesetRules->getRuleid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ruleset_rules table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetRulesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RulesetRulesTableMap::clearInstancePool();
            RulesetRulesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RulesetRulesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RulesetRulesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RulesetRulesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RulesetRulesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RulesetRulesQuery
