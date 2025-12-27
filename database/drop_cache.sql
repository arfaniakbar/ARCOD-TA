-- Drop cache tables to avoid PostgreSQL transaction issues
DROP TABLE IF EXISTS cache CASCADE;
DROP TABLE IF EXISTS cache_locks CASCADE;
