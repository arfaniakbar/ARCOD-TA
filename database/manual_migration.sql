-- Manual PostgreSQL migration for Neon
-- Drop all existing tables
DROP TABLE IF EXISTS evidences CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS pangwas CASCADE;
DROP TABLE IF EXISTS tematik CASCADE;
DROP TABLE IF EXISTS purchase_order CASCADE;
DROP TABLE IF EXISTS project CASCADE;
DROP TABLE IF EXISTS cache CASCADE;
DROP TABLE IF EXISTS cache_locks CASCADE;
DROP TABLE IF EXISTS jobs CASCADE;
DROP TABLE IF EXISTS job_batches CASCADE;
DROP TABLE IF EXISTS failed_jobs CASCADE;
DROP TABLE IF EXISTS sessions CASCADE;
DROP TABLE IF EXISTS migrations CASCADE;

-- Create users table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'karyawan',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Create pangwas table
CREATE TABLE pangwas (
    id SERIAL PRIMARY KEY,
    nama_pangwas VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Create tematik table
CREATE TABLE tematik (
    id SERIAL PRIMARY KEY,
    nama_tematik VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Create purchase_order table
CREATE TABLE purchase_order (
    id SERIAL PRIMARY KEY,
    no_po VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Create project table
CREATE TABLE project (
    id SERIAL PRIMARY KEY,
    lokasi VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    ts TIMESTAMP NULL
);

-- Create evidences table
CREATE TABLE evidences (
    id SERIAL PRIMARY KEY,
    project_id INTEGER NULL,
    po_id INTEGER NULL,
    pangwas_id INTEGER NULL,
    tematik_id INTEGER NULL,
    user_id INTEGER NOT NULL,
    lokasi VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    file_path TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    catatan_admin TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (pangwas_id) REFERENCES pangwas(id) ON DELETE SET NULL,
    FOREIGN KEY (tematik_id) REFERENCES tematik(id) ON DELETE SET NULL,
    FOREIGN KEY (po_id) REFERENCES purchase_order(id) ON DELETE SET NULL
);

-- Create cache table
CREATE TABLE cache (
    key VARCHAR(255) NOT NULL UNIQUE,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

-- Create cache_locks table
CREATE TABLE cache_locks (
    key VARCHAR(255) NOT NULL UNIQUE,
    owner VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL
);

-- Create jobs table
CREATE TABLE jobs (
    id SERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts SMALLINT NOT NULL,
    reserved_at INTEGER NULL,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

CREATE INDEX jobs_queue_index ON jobs(queue);

-- Create job_batches table
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INTEGER NOT NULL,
    pending_jobs INTEGER NOT NULL,
    failed_jobs INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT NULL,
    cancelled_at INTEGER NULL,
    created_at INTEGER NOT NULL,
    finished_at INTEGER NULL
);

-- Create failed_jobs table
CREATE TABLE failed_jobs (
    id SERIAL PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Create sessions table
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

CREATE INDEX sessions_user_id_index ON sessions(user_id);
CREATE INDEX sessions_last_activity_index ON sessions(last_activity);

-- Create migrations table
CREATE TABLE migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INTEGER NOT NULL
);
