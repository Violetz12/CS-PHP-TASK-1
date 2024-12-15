<?php
session_start();

// Determine which room we're in based on URL parameter
$current_room = isset($_GET['room']) ? $_GET['room'] : '';

// Mark the room as visited in the session
switch($current_room) {
    case 'living_room':
        $_SESSION['living_room_visited'] = true;
        $room_details = [
            'title' => 'Living Room',
            'description' => 'As you enter the living room, an eerie silence greets you. The space looks like it has been the scene of a violent encounter.',
            'clues' => [
                [
                    'title' => 'Broken Vase',
                    'description' => 'An elegant vase lies shattered on the floor. Closer inspection reveals potential fingerprints on the ceramic fragments.'
                ],
                [
                    'title' => 'Whiskey Glass',
                    'description' => 'A half-empty whiskey glass sits on the side table. Lipstick marks rim the edge, suggesting recent use.'
                ]
            ]
        ];
        break;
    case 'kitchen':
        $_SESSION['kitchen_visited'] = true;
        $room_details = [
            'title' => 'Kitchen',
            'description' => 'The kitchen appears slightly disheveled. A knife is out of place, and there are signs of a hasty departure.',
            'clues' => [
                [
                    'title' => 'Dropped Knife',
                    'description' => 'A kitchen knife lies on the floor, with what appears to be a trace of blood.'
                ],
                [
                    'title' => 'Half-Eaten Meal',
                    'description' => 'A plate with half-eaten food suggests someone was interrupted mid-meal.'
                ]
            ]
        ];
        break;
    case 'bedroom':
        $_SESSION['bedroom_visited'] = true;
        $room_details = [
            'title' => 'Bedroom',
            'description' => 'The bedroom is in complete disarray. Drawers are pulled out, and personal items are scattered across the floor.',
            'clues' => [
                [
                    'title' => 'Open Diary',
                    'description' => 'A diary lies open, with a recent entry partially visible.'
                ],
                [
                    'title' => 'Hidden Letter',
                    'description' => 'A crumpled letter is found tucked behind the nightstand.'
                ]
            ]
        ];
        break;
    default:
        // Redirect back to house if no room is specified
        header('Location: index.php');
        exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $room_details['title']; ?> - Murder Mystery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .room-container {
            background-color: rgba(44, 62, 80, 0.9);
            border-radius: 10px;
            padding: 30px;
            max-width: 800px;
            width: 90%;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }

        .room-title {
            text-align: center;
            color: #8e44ad;
            border-bottom: 2px solid #8e44ad;
            padding-bottom: 15px;
        }

        .room-description {
            margin: 20px 0;
            line-height: 1.6;
        }

        .clues {
            background-color: rgba(39, 174, 96, 0.1);
            border-radius: 8px;
            padding: 20px;
        }

        .clue {
            margin-bottom: 15px;
            padding: 10px;
            background-color: rgba(52, 73, 94, 0.5);
            border-left: 4px solid #8e44ad;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #8e44ad;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #9b59b6;
        }
    </style>
</head>
<body>
    <div class="room-container">
        <h1 class="room-title"><?php echo $room_details['title']; ?></h1>
        
        <div class="room-description">
            <p><?php echo $room_details['description']; ?></p>
        </div>

        <div class="clues">
            <h2>Discovered Clues</h2>
            <?php foreach($room_details['clues'] as $clue): ?>
                <div class="clue">
                    <h3><?php echo htmlspecialchars($clue['title']); ?></h3>
                    <p><?php echo htmlspecialchars($clue['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="navigation">
            <a href="index.php" class="btn">Back to House</a>
            <?php 
            // Check if all rooms have been visited
            $all_rooms_visited = isset($_SESSION['living_room_visited']) && 
                                 isset($_SESSION['kitchen_visited']) && 
                                 isset($_SESSION['bedroom_visited']);
            
            if($all_rooms_visited): ?>
                <a href="solution.php" class="btn">Submit Solution</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>