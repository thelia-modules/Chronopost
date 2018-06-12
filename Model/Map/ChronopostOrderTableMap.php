<?php

namespace Chronopost\Model\Map;

use Chronopost\Model\ChronopostOrder;
use Chronopost\Model\ChronopostOrderQuery;
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
 * This class defines the structure of the 'chronopost_order' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ChronopostOrderTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Chronopost.Model.Map.ChronopostOrderTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'chronopost_order';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Chronopost\\Model\\ChronopostOrder';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Chronopost.Model.ChronopostOrder';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID field
     */
    const ID = 'chronopost_order.ID';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'chronopost_order.ORDER_ID';

    /**
     * the column name for the DELIVERY_TYPE field
     */
    const DELIVERY_TYPE = 'chronopost_order.DELIVERY_TYPE';

    /**
     * the column name for the DELIVERY_CODE field
     */
    const DELIVERY_CODE = 'chronopost_order.DELIVERY_CODE';

    /**
     * the column name for the LABEL_DIRECTORY field
     */
    const LABEL_DIRECTORY = 'chronopost_order.LABEL_DIRECTORY';

    /**
     * the column name for the LABEL_NUMBER field
     */
    const LABEL_NUMBER = 'chronopost_order.LABEL_NUMBER';

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
        self::TYPE_PHPNAME       => array('Id', 'OrderId', 'DeliveryType', 'DeliveryCode', 'LabelDirectory', 'LabelNumber', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'orderId', 'deliveryType', 'deliveryCode', 'labelDirectory', 'labelNumber', ),
        self::TYPE_COLNAME       => array(ChronopostOrderTableMap::ID, ChronopostOrderTableMap::ORDER_ID, ChronopostOrderTableMap::DELIVERY_TYPE, ChronopostOrderTableMap::DELIVERY_CODE, ChronopostOrderTableMap::LABEL_DIRECTORY, ChronopostOrderTableMap::LABEL_NUMBER, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'ORDER_ID', 'DELIVERY_TYPE', 'DELIVERY_CODE', 'LABEL_DIRECTORY', 'LABEL_NUMBER', ),
        self::TYPE_FIELDNAME     => array('id', 'order_id', 'delivery_type', 'delivery_code', 'label_directory', 'label_number', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'OrderId' => 1, 'DeliveryType' => 2, 'DeliveryCode' => 3, 'LabelDirectory' => 4, 'LabelNumber' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'orderId' => 1, 'deliveryType' => 2, 'deliveryCode' => 3, 'labelDirectory' => 4, 'labelNumber' => 5, ),
        self::TYPE_COLNAME       => array(ChronopostOrderTableMap::ID => 0, ChronopostOrderTableMap::ORDER_ID => 1, ChronopostOrderTableMap::DELIVERY_TYPE => 2, ChronopostOrderTableMap::DELIVERY_CODE => 3, ChronopostOrderTableMap::LABEL_DIRECTORY => 4, ChronopostOrderTableMap::LABEL_NUMBER => 5, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'ORDER_ID' => 1, 'DELIVERY_TYPE' => 2, 'DELIVERY_CODE' => 3, 'LABEL_DIRECTORY' => 4, 'LABEL_NUMBER' => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'order_id' => 1, 'delivery_type' => 2, 'delivery_code' => 3, 'label_directory' => 4, 'label_number' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('chronopost_order');
        $this->setPhpName('ChronopostOrder');
        $this->setClassName('\\Chronopost\\Model\\ChronopostOrder');
        $this->setPackage('Chronopost.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('ORDER_ID', 'OrderId', 'INTEGER', 'order', 'ID', true, null, null);
        $this->addColumn('DELIVERY_TYPE', 'DeliveryType', 'LONGVARCHAR', false, null, null);
        $this->addColumn('DELIVERY_CODE', 'DeliveryCode', 'LONGVARCHAR', false, null, null);
        $this->addColumn('LABEL_DIRECTORY', 'LabelDirectory', 'LONGVARCHAR', false, null, null);
        $this->addColumn('LABEL_NUMBER', 'LabelNumber', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Order', '\\Chronopost\\Model\\Thelia\\Model\\Order', RelationMap::MANY_TO_ONE, array('order_id' => 'id', ), 'CASCADE', 'RESTRICT');
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
        return $withPrefix ? ChronopostOrderTableMap::CLASS_DEFAULT : ChronopostOrderTableMap::OM_CLASS;
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
     * @return array (ChronopostOrder object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ChronopostOrderTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ChronopostOrderTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ChronopostOrderTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ChronopostOrderTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ChronopostOrderTableMap::addInstanceToPool($obj, $key);
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
            $key = ChronopostOrderTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ChronopostOrderTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ChronopostOrderTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ChronopostOrderTableMap::ID);
            $criteria->addSelectColumn(ChronopostOrderTableMap::ORDER_ID);
            $criteria->addSelectColumn(ChronopostOrderTableMap::DELIVERY_TYPE);
            $criteria->addSelectColumn(ChronopostOrderTableMap::DELIVERY_CODE);
            $criteria->addSelectColumn(ChronopostOrderTableMap::LABEL_DIRECTORY);
            $criteria->addSelectColumn(ChronopostOrderTableMap::LABEL_NUMBER);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.DELIVERY_TYPE');
            $criteria->addSelectColumn($alias . '.DELIVERY_CODE');
            $criteria->addSelectColumn($alias . '.LABEL_DIRECTORY');
            $criteria->addSelectColumn($alias . '.LABEL_NUMBER');
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
        return Propel::getServiceContainer()->getDatabaseMap(ChronopostOrderTableMap::DATABASE_NAME)->getTable(ChronopostOrderTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ChronopostOrderTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ChronopostOrderTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ChronopostOrderTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a ChronopostOrder or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChronopostOrder object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostOrderTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Chronopost\Model\ChronopostOrder) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ChronopostOrderTableMap::DATABASE_NAME);
            $criteria->add(ChronopostOrderTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ChronopostOrderQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ChronopostOrderTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ChronopostOrderTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the chronopost_order table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ChronopostOrderQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ChronopostOrder or Criteria object.
     *
     * @param mixed               $criteria Criteria or ChronopostOrder object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChronopostOrderTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ChronopostOrder object
        }

        if ($criteria->containsKey(ChronopostOrderTableMap::ID) && $criteria->keyContainsValue(ChronopostOrderTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ChronopostOrderTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ChronopostOrderQuery::create()->mergeWith($criteria);

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

} // ChronopostOrderTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ChronopostOrderTableMap::buildTableMap();
