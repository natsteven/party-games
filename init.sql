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
    user_id INTEGER PRIMARY KEY,
    preference_id INTEGER,
    preference_value TEXT,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(preference_id) REFERENCES preferences(id)
);

CREATE TABLE IF NOT EXISTS game_sessions (
    room_code TEXT PRIMARY KEY,
    host_user_id INTEGER,
    host_guest_id INTEGER,
    game_state TEXT,
    expected_players INTEGER,
    num_red_herrings INTEGER,
    FOREIGN KEY(host_user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS game_players (
    player_id INTEGER PRIMARY KEY,
    alias TEXT,
    room_code TEXT,
    user_id INTEGER,
    FOREIGN KEY(room_code) REFERENCES game_sessions(room_code),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS user_input (
    input_id INTEGER PRIMARY KEY,
    room_code TEXT,
    player_id INTEGER,
    input TEXT,
    FOREIGN KEY(room_code) REFERENCES game_sessions(room_code),
    FOREIGN KEY(player_id) REFERENCES game_players(player_id)
);

CREATE TABLE IF NOT EXISTS redherrings (
    name TEXT PRIMARY KEY
);
