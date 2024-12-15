<?php
session_start();

// List of valid solutions
$valid_solutions = [
    'murderer' => 'Clara Pierce',
    'room' => 'The Living Room',     // based on where the murder might have occurred
    'weapon' => 'Candlestick'       // based on your weapons list
];

// Predefined dropdown options
$murderer_options = ['Select Murderer', 'Clara Pierce', 'George Walker', 'Maya Fields', 'Harrison Drake'];
$room_options = ['Select Room', 'The Living Room', 'The Study', 'The Music Room', 'The Library'];
$weapon_options = ['Select Weapon', 'Candlestick', 'Knife', 'Rope', 'Revolver'];

// Check if all rooms have been visited
$can_submit_solution = isset($_SESSION['living_room_visited']) && 
                       isset($_SESSION['study_visited']) && 
                       isset($_SESSION['music_room_visited']) && 
                       isset($_SESSION['library_visited']);

// Handle solution submission
$solution_result = null;
if($_SERVER['REQUEST_METHOD'] == 'POST' && $can_submit_solution) {
    $murderer = isset($_POST['murderer']) ? trim(strtolower($_POST['murderer'])) : '';
    $room = isset($_POST['room']) ? trim(strtolower($_POST['room'])) : '';
    $weapon = isset($_POST['weapon']) ? trim(strtolower($_POST['weapon'])) : '';

     // Check each solution component separately
    if ($murderer !== strtolower($valid_solutions['murderer'])) {
        $error_details[] = "Murderer: The killer is not who you think.";
    }

    if ($room !== strtolower($valid_solutions['room'])) {
        $error_details[] = "Crime Scene: The murder did not occur in the room you selected.";
    }

    if ($weapon !== strtolower($valid_solutions['weapon'])) {
        $error_details[] = "Murder Weapon: The weapon you chose was not used in the crime.";
    }

    // Check if all solution components are correct
    $solution_correct = 
        $murderer === strtolower($valid_solutions['murderer']) &&
        $room === strtolower($valid_solutions['room']) &&
        $weapon === strtolower($valid_solutions['weapon']);

    if($solution_correct) {
        $solution_result = true;
        $_SESSION['solution_solved'] = true;
    } else {
        $solution_result = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solve the Murder Mystery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .solution-container {
            background-color: rgba(44, 62, 80, 0.9);
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }

        .solution-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .solution-form select, 
        .solution-form textarea {
            width: 100%;
            padding: 10px;
            background-color: rgba(52, 73, 94, 0.5);
            border: 1px solid #8e44ad;
            color: #ecf0f1;
            border-radius: 5px;
        }

        .solution-form select option {
            background-color: #2c3e50;
            color: #ecf0f1;
        }

        .submit-button {
            background-color: #8e44ad;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #9b59b6;
        }

        .result-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            background-color: rgba(39, 174, 96, 0.3);
            color: #2ecc71;
        }

        .failure {
            background-color: rgba(231, 76, 60, 0.3);
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="solution-container">
        <h1 style="text-align: center; color: #8e44ad;">Solve the Murder</h1>

        <?php if($can_submit_solution): ?>
            <form method="POST" class="solution-form">
                <select name="murderer" required>
                    <?php foreach($murderer_options as $option): ?>
                        <option value="<?php echo strtolower($option); ?>"><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="room" required>
                    <?php foreach($room_options as $option): ?>
                        <option value="<?php echo strtolower($option); ?>"><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="weapon" required>
                    <?php foreach($weapon_options as $option): ?>
                        <option value="<?php echo strtolower($option); ?>"><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="submit-button">Submit Solution</button>
            </form>

            <?php if($solution_result !== null): ?>
                <div class="result-message <?php echo $solution_result ? 'success' : 'failure'; ?>">
                    <?php echo $solution_result ? 'Congratulations! You solved the murder.' : 'Incorrect solution. Try again.'; ?>
                    
                    <?php if(!$solution_result && !empty($error_details)): ?>
                        <div class="error-details">
                            <p>Here are some clues about where your deduction went wrong:</p>
                            <ul>
                                <?php foreach($error_details as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p style="text-align: center;">You must explore all rooms before submitting a solution.</p>
        <?php endif; ?>
    </div>
</body>
</html>