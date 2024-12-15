<?php
// Initialize a session to track clue discovery
session_start();

// Simulate clue discovery (in a real application, this would be more sophisticated)
$_SESSION['living_room_visited'] = true;

// Array of clues that might be revealed based on user interactions
$clues = [
    'Candlestick' => [
        'title' => 'The Candlestick',
        'description' => 'A heavy candlestick lies on the floor near the bloodstain. It has a
faint smear of blood on it, and a small dent in the metal suggests it was used to
strike someone’s head. The fingerprints on it belong to Clara.
',
        'is_discovered' => true
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Living Room - Murder Mystery</title>
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
        <h1>Living Room</h1>
        
        <?php if(isset($_SESSION['living_room_visited'])): ?>
            <img src="Living Room.jpeg" class="room-image">
            
            <div class="room-description">
                <p>The Living Room is spacious and opulent, with luxurious
                   furniture and grand windows that overlook the estate’s 
                   garden. The lighting is soft, and a large fireplace 
                   crackles in the corner. There’s a grand piano against 
                   one wall, and a large painting of Reginald hangs above
                   the mantel. A bloodstain near the fireplace catches 
                   your eye. </p>
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
            <?php if(isset($_SESSION['living_room_visited'])): ?>
                <a href="room2.php" class="back-button" style="margin-left: 20px;">Explore Next Room</a>
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