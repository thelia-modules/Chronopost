<?php

namespace Chronopost\Model\Map;

use Chronopost\Model\ChronopostPrice;
use Chronopost\Model\ChronopostPriceQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'chronopost_price' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ChronopostPriceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Chronopost.Model.Map.ChronopostPriceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'chronopost_price';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Chronopost\\Model\\ChronopostPrice';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Chronopost.Model.ChronopostPrice';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ID field
     */
    const ID = 'chronopost_price.ID';

    /**
     * the column name for the AREA_ID field
     */
    const AREA_ID = 'chronopost_price.AREA_ID';

    /**
     * the column name for the DELIVERY_MODE_ID field
     */
    const DELIVERY_MODE_ID = 'chronopost_price.DELIVERY_MODE_ID';

    /**
     * the column name for the WEIGHT_MAX field
     */
    const WEIGHT_MAX = 'chronopost_price.WEIGHT_MAX';

    /**
     * the column name for the PRICE_MAX field
     */
    const PRICE_MAX = 'chronopost_price.PRICE_MAX';

    /**
     * the column name for the FRANCO_MIN_PRICE field
     */
    const FRANCO_MIN_PRICE = 'chronopost_price.FRANCO_MIN_PRICE';

    /**
     * the column name for the PRICE field
     */
    const PRICE = 'chronopost_price.PRICE';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'AreaId', 'DeliveryModeId', 'WeightMax', 'PriceMax', 'FrancoMinPrice', 'Price', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'areaId', 'deliveryModeId', 'weightMax', 'priceMax', 'francoMinPrice', 'price', ),
        self::TYPE_COLNAME       => array(ChronopostPriceTableMap::ID, ChronopostPriceTableMap::AREA_ID, ChronopostPriceTableMap::DELIVERY_MODE_ID, ChronopostPriceTableMap::WEIGHT_MAX, ChronopostPriceTableMap::PRICE_MAX, ChronopostPriceTableMap::FRANCO_MIN_PRICE, ChronopostPriceTableMap::PRICE, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'AREA_ID', 'DELIVERY_MODE_ID', 'WEIGHT_MAX', 'PRICE_MAX', 'FRANCO_MIN_PRICE', 'PRICE', ),
        self::TYPE_FIELDNAME     => array('id', 'area_id', 'delivery_mode_id', 'weight_max', 'price_max', 'franco_min_price', 'price', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'AreaId' => 1, 'DeliveryModeId' => 2, 'WeightMax' => 3, 'PriceMax' => 4, 'FrancoMinPrice' => 5, 'Price' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'areaId' => 1, 'deliveryModeId' => 2, 'weightMax' => 3, 'priceMax' => 4, 'francoMinPrice' => 5, 'price' => 6, ),
        self::TYPE_COLNAME       => array(ChronopostPriceTableMap::ID => 0, ChronopostPriceTableMap::AREA_ID => 1, ChronopostPriceTableMap::DELIVERY_MODE_ID => 2, ChronopostPriceTableMap::WEIGHT_MAX => 3, ChronopostPriceTableMap::PRICE_MAX => 4, ChronopostPriceTableMap::FRANCO_MIN_PRICE => 5, ChronopostPriceTableMap::PRICE => 6, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'AREA_ID' => 1, 'DELIVERY_MODE_ID' => 2, 'WEIGHT_MAX' => 3, 'PRICE_MAX' => 4, 'FRANCO_MIN_PRICE' => 5, 'PRICE' => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'area_id' => 1, 'delivery_mode_id' => 2, 'weight_max' => 3, 'price_max' => 4, 'franco_min_price' => 5, 'price' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('chronopost_price');
        $this->setPhpName('ChronopostPrice');
        $this->setClassName('\\Chronopost\\Model\\ChronopostPrice');
        $this->setPackage('Chronopost.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('AREA_ID', 'AreaId', 'INTEGER', 'area', 'ID', true, null, null);
        $this->addForeignKey('DELIVERY_MODE_ID', 'DeliveryModeId', 'INTEGER', 'chronopost_delivery_mode', 'ID', true, null, null);
        $this->addColumn('WEIGHT_MAX', 'WeightMax', 'FLOAT', false, null, null);
        $this->addColumn('PRICE_MAX', 'PriceMax', 'FLOAT', false, null, null);
        $this->addColumn('FRANCO_MIN_PRICE', 'FrancoMinPrice', 'FLOAT', false, null, null);
        $this->addColumn('PRICE', 'Price', 'FLOAT', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Area', '\\Chronopost\\Model\\Thelia\\Model\\Area', RelationMap::MANY_TO_ONE, array('area_id' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('ChronopostDeliveryMode', '\\Chronopost\\Model\\ChronopostDeliveryMode', RelationMap::MANY_TO_ONE, array('delivery_mode_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ChronopostPriceTableMap::CLASS_DEFAULT : ChronopostPriceTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (ChronopostPrice object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ChronopostPriceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ChronopostPriceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ChronopostPriceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ChronopostPriceTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ChronopostPriceTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ChronopostPriceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ChronopostPriceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ChronopostPriceTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ChronopostPriceTableMap::ID);
            $criteria->addSelectColumn(ChronopostPriceTableMap::AREA_ID);
            $criteria->addSelectColumn(ChronopostPriceTableMap::DELIVERY_MODE_ID);
            $criteria->addSelectColumn(ChronopostPriceTableMap::WEIGHT_MAX);
            $criteria->addSelectColumn(ChronopostPriceTableMap::PRICE_MAX);
            $criteria->addSelectColumn(ChronopostPriceTableMap::FRANCO_MIN_PRICE);
            $criteria->addSelectColumn(ChronopostPriceTableMap::PRICE);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.AREA_ID');
            $criteria->addSelectColumn($alias . '.DELIVERY_MODE_ID');
            $criteria->addSelectColumn($alias . '.WEIGHT_MAX');
            $criteria->addSelectColumn($alias . '.PRICE_MAX');
            $criteria->addSelectColumn($alias . '.FRANCO_MIN_PRICE');
            $criteria->addSelectColumn($alias . '.PRICE');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ChronopostPriceTableMap::DATABASE_NAME)->getTable(ChronopostPriceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ChronopostPriceTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ChronopostPriceTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ChronopostPriceTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a ChronopostPrice or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChronopostPrice object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostPriceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Chronopost\Model\ChronopostPrice) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ChronopostPriceTableMap::DATABASE_NAME);
            $criteria->add(ChronopostPriceTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ChronopostPriceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ChronopostPriceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ChronopostPriceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the chronopost_price table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ChronopostPriceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ChronopostPrice or Criteria object.
     *
     * @param mixed               $criteria Criteria or ChronopostPrice object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostPriceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ChronopostPrice object
        }

        if ($criteria->containsKey(ChronopostPriceTableMap::ID) && $criteria->keyContainsValue(ChronopostPriceTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ChronopostPriceTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ChronopostPriceQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // ChronopostPriceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ChronopostPriceTableMap::buildTableMap();
