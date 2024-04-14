CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    email TEXT UNIQUE,
    password TEXT
);

CREATE TABLE IF NOT EXISTS admins (
    email TEXT PRIMARY KEY
);

-- CREATE TABLE IF NOT EXISTS preferences (
--     id INTEGER PRIMARY KEY,
--     preference_name TEXT
-- );

-- CREATE TABLE IF NOT EXISTS user_preferences (
--     player_id INTEGER PRIMARY KEY,
--     preference_id INTEGER,
--     preference_value TEXT,
--     FOREIGN KEY(player_id) REFERENCES users(id),
--     FOREIGN KEY(preference_id) REFERENCES preferences(id)
-- );

CREATE TABLE IF NOT EXISTS game_sessions (
    room_code INTEGER PRIMARY KEY,
    host_id TEXT,
    expected_players INTEGER,
    num_red_herrings INTEGER,
    started BOOLEAN
);

CREATE TABLE IF NOT EXISTS game_players (
    player_id TEXT PRIMARY KEY,
    alias TEXT,
    room_code INTEGER,
    FOREIGN KEY(room_code) REFERENCES game_sessions(room_code)
);

CREATE TABLE IF NOT EXISTS redherrings (
    name TEXT PRIMARY KEY
);
