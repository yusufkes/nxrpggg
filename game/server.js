// Load necessary modules
const express = require('express');
const session = require('express-session');

const app = express();
const PORT = process.env.PORT || 4000;

app.use('/game', express.static(path.join(__dirname, 'public_html/game')));
app.get('/game', (req, res) => {
    res.sendFile(path.join(__dirname, 'public_html/game', 'game.php')); // Serve the game entry point
});

// Middleware Setup
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(session({
    secret: process.env.SESSION_SECRET || 'default_secret',
    resave: false,
    saveUninitialized: true,
    cookie: { secure: false }
}));

// Example endpoint for APIs (like battle logic or chat)
app.post('/battle', (req, res) => {
    const { action } = req.body;

    // Simplified battle example
    if (action === 'attack') {
        const player = req.session.player || { health: 100, attack: 10 };
        const enemy = { health: 50, attack: 5 };  // Example enemy

        enemy.health -= player.attack;

        if (enemy.health <= 0) {
            res.json({ message: "Victory!" });
        } else {
            player.health -= enemy.attack;
            if (player.health <= 0) {
                res.json({ message: "Defeat!" });
            } else {
                res.json({ message: "Battle continues..." });
            }
        }
    }
});

// Start server (only for APIs)
app.listen(PORT, () => {
    console.log(`Node.js server is running on port ${PORT}`);
});
