CREATE TABLE IF NOT EXISTS Tasks (
    id SERIAL PRIMARY KEY,
    meeting_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date TIMESTAMP,
    status VARCHAR(20) CHECK (status IN ('pending', 'in_progress', 'completed')) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (meeting_id) REFERENCES Meetings(id) ON DELETE CASCADE
);
