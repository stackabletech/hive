-- Test Incremental rebuild of materialized view without aggregate when source tables have
-- 1) insert operations only
-- 2) update/delete operations since last rebuild.

SET hive.vectorized.execution.enabled=false;
set hive.support.concurrency=true;
set hive.txn.manager=org.apache.hadoop.hive.ql.lockmgr.DbTxnManager;
set hive.strict.checks.cartesian.product=false;
set hive.materializedview.rewriting=true;

create table cmv_basetable_n6 (a int, b varchar(256), c decimal(10,2), d int) stored as orc TBLPROPERTIES ('transactional'='true');

insert into cmv_basetable_n6 values
 (1, 'alfred', 10.30, 2),
 (1, 'alfred', 10.30, 2),
 (1, 'alfred', 10.30, 2),
 (2, 'bob', 3.14, 3),
 (2, 'bonnie', 172342.2, 3),
 (3, 'calvin', 978.76, 3),
 (3, 'charlie', 9.8, 1);

create table cmv_basetable_2_n3 (a int, b varchar(256), c decimal(10,2), d int) stored as orc TBLPROPERTIES ('transactional'='true');

insert into cmv_basetable_2_n3 values
 (1, 'alfred', 10.30, 2),
 (1, 'alfred', 10.30, 2),
 (3, 'calvin', 978.76, 3);

CREATE MATERIALIZED VIEW cmv_mat_view_n6
  TBLPROPERTIES ('transactional'='true') AS
  SELECT cmv_basetable_n6.a, cmv_basetable_2_n3.c
  FROM cmv_basetable_n6 JOIN cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
  WHERE cmv_basetable_2_n3.c > 10.0;

insert into cmv_basetable_2_n3 values
 (3, 'charlie', 15.8, 1);

-- CANNOT USE THE VIEW, IT IS OUTDATED
EXPLAIN
SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 join cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 JOIN cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

-- REBUILD
EXPLAIN
ALTER MATERIALIZED VIEW cmv_mat_view_n6 REBUILD;

ALTER MATERIALIZED VIEW cmv_mat_view_n6 REBUILD;

DESCRIBE FORMATTED cmv_mat_view_n6;

-- NOW IT CAN BE USED AGAIN
EXPLAIN
SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 join cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 JOIN cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

-- NOW AN UPDATE
UPDATE cmv_basetable_2_n3 SET a=2 WHERE a=1;

-- INCREMENTAL REBUILD CAN BE TRIGGERED
EXPLAIN
ALTER MATERIALIZED VIEW cmv_mat_view_n6 REBUILD;

ALTER MATERIALIZED VIEW cmv_mat_view_n6 REBUILD;

-- MV CAN BE USED
EXPLAIN
SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 join cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 JOIN cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

-- NOW A DELETE
DELETE FROM cmv_basetable_2_n3 WHERE a=2;

-- INCREMENTAL REBUILD CAN BE TRIGGERED
EXPLAIN
ALTER MATERIALIZED VIEW cmv_mat_view_n6 REBUILD;

ALTER MATERIALIZED VIEW cmv_mat_view_n6 REBUILD;

-- MV CAN BE USED
EXPLAIN
SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 join cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 JOIN cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

-- NOW AN INSERT
insert into cmv_basetable_2_n3 values
 (1, 'charlie', 15.8, 1);

-- INCREMENTAL REBUILD CAN BE TRIGGERED AGAIN
EXPLAIN
ALTER MATERIALIZED VIEW cmv_mat_view_n6 REBUILD;

ALTER MATERIALIZED VIEW cmv_mat_view_n6 REBUILD;

-- MV CAN BE USED
EXPLAIN
SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 join cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

SELECT cmv_basetable_n6.a
FROM cmv_basetable_n6 JOIN cmv_basetable_2_n3 ON (cmv_basetable_n6.a = cmv_basetable_2_n3.a)
WHERE cmv_basetable_2_n3.c > 10.10;

drop materialized view cmv_mat_view_n6;
