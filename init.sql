CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY,
    email TEXT UNIQUE,
    password TEXT
);

CREATE TABLE IF NOT EXISTS preferences (
    id INTEGER PRIMARY KEY,
    preference_name TEXT
);

CREATE TABLE IF NOT EXISTS user_preferences (
    user_id INTEGER,
    preference_id INTEGER,
    preference_value TEXT,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(preference_id) REFERENCES preferences(id)
);

CREATE TABLE IF NOT EXISTS redherrings (
    name TEXT PRIMARY KEY
);
