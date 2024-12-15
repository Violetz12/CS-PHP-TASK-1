<?php
session_start();
$rooms_visited = [
    'living_room' => isset($_SESSION['living_room_visited']) ? 1 : 0,
    'study' => isset($_SESSION['study_visited']) ? 1 : 0,
    'music_room' => isset($_SESSION['music_room_visited']) ? 1 : 0,
    'library' => isset($_SESSION['library_visited']) ? 1 : 0
];

// Story details
$story_details = [
    'victim' => [
        'name' => 'Reginald Pierce',
        'description' => 'A wealthy businessman, found dead in his mansion.',
        'cause_of_death' => 'Blunt force trauma to the head'
    ],
    'goal' => 'Players need to determine: Who did it? Where did they do it? What weapon was used?',
    'suspects' => [
        'Clara Pierce' => 'The victim\'s wife. Quiet, elegant, but hiding a few secrets. She had recently discovered some of her husband\'s shady business dealings.',
        'George Walker' => 'The victim\'s business partner. Charismatic and ambitious, but he was often overshadowed by Reginald. There\'s a lot of tension between them lately.',
        'Maya Fields' => 'Reginald\'s personal assistant. Hard-working and professional, but she recently found out her job might be at risk due to budget cuts.',
        'Harrison Drake' => 'Reginald\'s childhood friend. Recently back in town after years of estrangement. He has a mysterious past, and his motives are unclear.'
    ],
    'weapons' => [
        'Candlestick',
        'Hammer',
        'Piano Wire',
        'Fireplace Poker'
    ],
    'rooms' => [
        'The Living Room',
        'The Study', 
        'The Music Room',
        'The Library'
    ]
];

// Check if all rooms have been visited
$all_rooms_visited = $rooms_visited['living_room'] && 
                     $rooms_visited['study'] && 
                     $rooms_visited['music_room'] && 
                     $rooms_visited['library'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Murder Mystery House</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: white;
        }

        .house {
            width: 800px;
            height: 500px;
            background-color: #34495e;
            position: relative;
            perspective: 1000px;
            border: 10px solid #2c3e50;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }

        .floor {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 70px;
            background-color: #7f8c8d;
        }

        .wall {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 430px;
            background-color: #95a5a6;
        }

        .door {
            width: 180px;
            height: 300px;
            background-color: #8e44ad;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border: 5px solid #6c3483;
        }

        .door:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }

        .door.visited {
            background-color: #566573;
        }

        .doorknob {
            width: 20px;
            height: 20px;
            background-color: #2c3e50;
            border-radius: 50%;
            position: absolute;
            right: 20px;
            top: 50%;
        }

        .door span {
            color: white;
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
        }

        .door-status {
            position: absolute;
            bottom: 10px;
            font-size: 12px;
            color: #d3d3d3;
        }

        .solution-button {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #8e44ad;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .solution-button:hover {
            background-color: #9b59b6;
        }

        .solution-button.hidden {
            display: none;
        }

        .story-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            z-index: 1000;
            overflow-y: auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .story-modal-content {
            background-color: #34495e;
            color: white;
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            position: relative;
        }

        .story-modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 30px;
            cursor: pointer;
        }

        .story-info-button {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #8e44ad;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .suspects-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
    </style>
</head>
<body>
    <div class="story-info-button" onclick="openStoryModal()">Story Info</div>
    <div class="house">
        <div class="floor"></div>
        <div class="wall">
            <div class="door <?php echo $rooms_visited['living_room'] ? 'visited' : ''; ?>" onclick="goToRoom('room1.php', 'living_room')">
                <div class="doorknob"></div>
                <span>Living Room</span>
                <div class="door-status">
                    <?php echo $rooms_visited['living_room'] ? 'Explored' : 'Unexplored'; ?>
                </div>
            </div>
            
            <div class="door <?php echo $rooms_visited['study'] ? 'visited' : ''; ?>" onclick="goToRoom('room2.php', 'study')">
                <div class="doorknob"></div>
                <span>Study</span>
                <div class="door-status">
                    <?php echo $rooms_visited['study'] ? 'Explored' : 'Unexplored'; ?>
                </div>
            </div>
            
            <div class="door <?php echo $rooms_visited['music_room'] ? 'visited' : ''; ?>" onclick="goToRoom('room3.php', 'music_room')">
                <div class="doorknob"></div>
                <span>Music Room</span>
                <div class="door-status">
                    <?php echo $rooms_visited['music_room'] ? 'Explored' : 'Unexplored'; ?>
                </div>
            </div>

            <div class="door <?php echo $rooms_visited['library'] ? 'visited' : ''; ?>" onclick="goToRoom('room4.php', 'library')">
                <div class="doorknob"></div>
                <span>Library</span>
                <div class="door-status">
                    <?php echo $rooms_visited['library'] ? 'Explored' : 'Unexplored'; ?>
                </div>
            </div>
        </div>

        <?php if($all_rooms_visited): ?>
            <a href="solution.php" class="solution-button">Solve the Murder</a>
        <?php endif; ?>
    </div>

    <div id="storyModal" class="story-modal">
        <div class="story-modal-content">
            <span class="story-modal-close" onclick="closeStoryModal()">&times;</span>
            
            <h1>Murder Mystery</h1>
            
            <h2>Victim</h2>
            <p><strong><?php echo $story_details['victim']['name']; ?></strong>: 
            <?php echo $story_details['victim']['description']; ?><br>
            Cause of Death: <?php echo $story_details['victim']['cause_of_death']; ?></p>
            
            <h2>Game Goal</h2>
            <p><?php echo $story_details['goal']; ?></p>
            
            <h2>Suspects</h2>
            <div class="suspects-grid">
                <?php foreach($story_details['suspects'] as $name => $description): ?>
                    <div>
                        <h3><?php echo htmlspecialchars($name); ?></h3>
                        <p><?php echo htmlspecialchars($description); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <h2>Possible Weapons</h2>
            <ul>
                <?php foreach($story_details['weapons'] as $weapon): ?>
                    <li><?php echo htmlspecialchars($weapon); ?></li>
                <?php endforeach; ?>
            </ul>
            
            <h2>Crime Scene Rooms</h2>
            <ul>
                <?php foreach($story_details['rooms'] as $room): ?>
                    <li><?php echo htmlspecialchars($room); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script>
        function goToRoom(roomUrl, roomName) {
            // Redirect to the room and pass room information
            window.location.href = roomUrl + '?room=' + roomName;
        }

        function openStoryModal() {
            document.getElementById('storyModal').style.display = 'block';
        }

        function closeStoryModal() {
            document.getElementById('storyModal').style.display = 'none';
        }
    </script>
</body>
</html>