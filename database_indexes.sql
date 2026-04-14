-- Performance Indexes for Leave Assignments Table
-- Run these queries to improve query performance

-- Index for user queries (most common)
CREATE INDEX idx_leave_assignments_user_id ON leave_assignments (user_id);

-- Index for leave type queries
CREATE INDEX idx_leave_assignments_leave_type_id ON leave_assignments (leave_type_id);

-- Composite index for user + year queries (very common)
CREATE INDEX idx_leave_assignments_user_year ON leave_assignments (user_id, year);

-- Composite index for leave type + year queries
CREATE INDEX idx_leave_assignments_leave_type_year ON leave_assignments (leave_type_id, year);

-- Index for year queries
CREATE INDEX idx_leave_assignments_year ON leave_assignments (year);

-- Additional indexes for users table if needed
CREATE INDEX idx_users_email ON users (email);
CREATE INDEX idx_users_role_id ON users (role_id);

-- Additional indexes for leave_types table if needed
CREATE INDEX idx_leave_types_is_active ON leave_types (is_active);

-- Query to check existing indexes
SHOW INDEX FROM leave_assignments;
SHOW INDEX FROM users;
SHOW INDEX FROM leave_types;

-- Query to analyze query performance
EXPLAIN SELECT * FROM leave_assignments WHERE user_id = 1;
EXPLAIN SELECT * FROM leave_assignments WHERE user_id = 1 AND year = 2026;
EXPLAIN SELECT * FROM leave_assignments WHERE leave_type_id = 1;
