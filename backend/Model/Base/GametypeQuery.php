<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Gametype as ChildGametype;
use Model\GametypeQuery as ChildGametypeQuery;
use Model\Map\GametypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'gametype' table.
 *
 *
 *
 * @method     ChildGametypeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGametypeQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildGametypeQuery groupById() Group by the id column
 * @method     ChildGametypeQuery groupByName() Group by the name column
 *
 * @method     ChildGametypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGametypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGametypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGametypeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGametypeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGametypeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGametypeQuery leftJoinGamedayruleset($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gamedayruleset relation
 * @method     ChildGametypeQuery rightJoinGamedayruleset($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gamedayruleset relation
 * @method     ChildGametypeQuery innerJoinGamedayruleset($relationAlias = null) Adds a INNER JOIN clause to the query using the Gamedayruleset relation
 *
 * @method     ChildGametypeQuery joinWithGamedayruleset($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gamedayruleset relation
 *
 * @method     ChildGametypeQuery leftJoinWithGamedayruleset() Adds a LEFT JOIN clause and with to the query using the Gamedayruleset relation
 * @method     ChildGametypeQuery rightJoinWithGamedayruleset() Adds a RIGHT JOIN clause and with to the query using the Gamedayruleset relation
 * @method     ChildGametypeQuery innerJoinWithGamedayruleset() Adds a INNER JOIN clause and with to the query using the Gamedayruleset relation
 *
 * @method     \Model\GamedayrulesetQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGametype|null findOne(ConnectionInterface $con = null) Return the first ChildGametype matching the query
 * @method     ChildGametype findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGametype matching the query, or a new ChildGametype object populated from the query conditions when no match is found
 *
 * @method     ChildGametype|null findOneById(int $id) Return the first ChildGametype filtered by the id column
 * @method     ChildGametype|null findOneByName(string $name) Return the first ChildGametype filtered by the name column *

 * @method     ChildGametype requirePk($key, ConnectionInterface $con = null) Return the ChildGametype by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGametype requireOne(ConnectionInterface $con = null) Return the first ChildGametype matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGametype requireOneById(int $id) Return the first ChildGametype filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGametype requireOneByName(string $name) Return the first ChildGametype filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGametype[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGametype objects based on current ModelCriteria
 * @method     ChildGametype[]|ObjectCollection findById(int $id) Return ChildGametype objects filtered by the id column
 * @method     ChildGametype[]|ObjectCollection findByName(string $name) Return ChildGametype objects filtered by the name column
 * @method     ChildGametype[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GametypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\GametypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Gametype', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGametypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGametypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGametypeQuery) {
            return $criteria;
        }
        $query = new ChildGametypeQuery();
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
     * @return ChildGametype|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GametypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GametypeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGametype A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name FROM gametype WHERE id = :p0';
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
            /** @var ChildGametype $obj */
            $obj = new ChildGametype();
            $obj->hydrate($row);
            GametypeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGametype|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGametypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GametypeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGametypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GametypeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGametypeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GametypeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GametypeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GametypeTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGametypeQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GametypeTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \Model\Gamedayruleset object
     *
     * @param \Model\Gamedayruleset|ObjectCollection $gamedayruleset the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGametypeQuery The current query, for fluid interface
     */
    public function filterByGamedayruleset($gamedayruleset, $comparison = null)
    {
        if ($gamedayruleset instanceof \Model\Gamedayruleset) {
            return $this
                ->addUsingAlias(GametypeTableMap::COL_ID, $gamedayruleset->getGametypeid(), $comparison);
        } elseif ($gamedayruleset instanceof ObjectCollection) {
            return $this
                ->useGamedayrulesetQuery()
                ->filterByPrimaryKeys($gamedayruleset->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGamedayruleset() only accepts arguments of type \Model\Gamedayruleset or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gamedayruleset relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGametypeQuery The current query, for fluid interface
     */
    public function joinGamedayruleset($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gamedayruleset');

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
            $this->addJoinObject($join, 'Gamedayruleset');
        }

        return $this;
    }

    /**
     * Use the Gamedayruleset relation Gamedayruleset object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\GamedayrulesetQuery A secondary query class using the current class as primary query
     */
    public function useGamedayrulesetQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGamedayruleset($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gamedayruleset', '\Model\GamedayrulesetQuery');
    }

    /**
     * Use the Gamedayruleset relation Gamedayruleset object
     *
     * @param callable(\Model\GamedayrulesetQuery):\Model\GamedayrulesetQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGamedayrulesetQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGamedayrulesetQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Gamedayruleset table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\GamedayrulesetQuery The inner query object of the EXISTS statement
     */
    public function useGamedayrulesetExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Gamedayruleset', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Gamedayruleset table for a NOT EXISTS query.
     *
     * @see useGamedayrulesetExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\GamedayrulesetQuery The inner query object of the NOT EXISTS statement
     */
    public function useGamedayrulesetNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Gamedayruleset', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param   ChildGametype $gametype Object to remove from the list of results
     *
     * @return $this|ChildGametypeQuery The current query, for fluid interface
     */
    public function prune($gametype = null)
    {
        if ($gametype) {
            $this->addUsingAlias(GametypeTableMap::COL_ID, $gametype->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the gametype table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GametypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GametypeTableMap::clearInstancePool();
            GametypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GametypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GametypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GametypeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GametypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GametypeQuery
