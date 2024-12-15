<?php
// Initialize a session to track clue discovery
session_start();

// Simulate clue discovery (in a real application, this would be more sophisticated)
$_SESSION['library_visited'] = true;

// Array of clues that might be revealed based on user interactions
$clues = [
    'Fireplace poker' => [
        'title' => 'The Fireplace Poker',
        'description' => 'The fireplace poker has blood on it, along with some hair that
seems to belong to Reginald. The poker looks like it has been used to bludgeon
someone, as there are noticeable dents in the metal.',
        'is_discovered' => true
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Murder Mystery</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #2c3e50;
            color: #ecf0f1;
            font-family: Arial, sans-serif;
        }
        .room-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(44, 62, 80, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .room-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .clue-list {
            background-color: rgba(52, 73, 94, 0.7);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .clue {
            margin-bottom: 15px;
            padding: 10px;
            background-color: rgba(39, 174, 96, 0.2);
            border-left: 4px solid #27ae60;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #8e44ad;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #9b59b6;
        }
    </style>
</head>
<body>
    <div class="room-container">
        <h1>Library</h1>
        
        <?php if(isset($_SESSION['library_visited'])): ?>
            <img src="Libraryy.jpeg" class="room-image">
            
            <div class="room-description">
                <p>The Library is filled with books on history and literature, with a large, leather
                    armchair beside a roaring fire. A fireplace poker leans against the mantel, and the
                    air smells of old books and wood smoke. There’s a stack of papers near the fireplace,
                    but they seem out of place.</p>
            </div>

            <div class="clue-list">
                <h2>Discovered Clues</h2>
                <?php foreach($clues as $clue): ?>
                    <?php if($clue['is_discovered']): ?>
                        <div class="clue">
                            <h3><?php echo htmlspecialchars($clue['title']); ?></h3>
                            <p><?php echo htmlspecialchars($clue['description']); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>You must explore the room carefully to uncover its secrets.</p>
        <?php endif; ?>

        <div class="navigation">
            <a href="index.php" class="back-button">Back to House</a>
            <?php if(isset($_SESSION['library_visited'])): ?>
                <a href="room1.php" class="back-button" style="margin-left: 20px;">Explore Next Room</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Optional: Add some interactive elements with JavaScript
        document.addEventListener('DOMContentLoaded', () => {
            const clues = document.querySelectorAll('.clue');
            clues.forEach(clue => {
                clue.addEventListener('click', () => {
                    clue.classList.toggle('expanded');
                });
            });
        });
    </script>
</body>
</html>