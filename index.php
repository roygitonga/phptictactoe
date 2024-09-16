<?php
session_start();

// Initialize game
function initGame() {
    $_SESSION['board'] = array_fill(0, 9, '1'); // 1 indicates empty cell
    $_SESSION['moves'] = [];
    $_SESSION['current_player'] = 'x'; // Player 1 starts
    $_SESSION['game_state'] = 'playing'; // Game in progress
    $_SESSION['player1_wins'] = 0; // Count of winning moves for Player 1
    $_SESSION['player2_wins'] = 0; // Count of winning moves for Player 2
}

// Print the game board
function printBoard($board) {
    echo '<table border="1" style="width: 300px; text-align: center;">';
    for ($i = 0; $i < 9; $i++) {
        $cellValue = ($board[$i] === '1') ? '' : $board[$i];
        $buttonDisabled = ($board[$i] === '1') ? '' : 'disabled';
        $buttonText = ($board[$i] === 'x') ? 'X' : (($board[$i] === 'o') ? 'O' : '');
        $buttonClass = ($board[$i] === 'x') ? 'player1' : (($board[$i] === 'o') ? 'player2' : 'empty');
        $cellContent = "<button type='button' class='cell $buttonClass' onclick='makeMove($i)' $buttonDisabled>$buttonText</button>";
        
        if ($i % 3 === 0) {
            echo '<tr>';
        }
        echo "<td style='width: 100px; height: 100px;'>$cellContent</td>";
        if ($i % 3 === 2) {
            echo '</tr>';
        }
    }
    echo '</table>';
}

// Check for win and return winning player or null
function checkWin($board, $player) {
    $winningCombinations = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
        [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
        [0, 4, 8], [2, 4, 6] // Diagonals
    ];

    foreach ($winningCombinations as $combination) {
        if (array_sum(array_map(function ($cell) use ($board, $player) {
            return $board[$cell] === $player ? 1 : 0;
        }, $combination)) === 3) {
            return $combination;
        }
    }

    return null;
}

// Find the best move for the computer
function findBestMove() {
    // Check if the computer can win
    $move = checkWin($_SESSION['board'], 'o');
    if ($move !== null) {
        return $move;
    }

    // Block player's winning move
    $move = checkWin($_SESSION['board'], 'x');
    if ($move !== null) {
        return $move;
    }

    // Choose a random available cell
    $availableCells = array_keys(array_filter($_SESSION['board'], fn($cell) => $cell === '1'));
    if (!empty($availableCells)) {
        return $availableCells[array_rand($availableCells)];
    }

    return null;
}

// Handle a player's move
function playerMove($cell) {
    if ($_SESSION['game_state'] === 'playing' && $_SESSION['board'][$cell] === '1') {
        $_SESSION['board'][$cell] = 'x'; // Player 1 move
        $_SESSION['moves'][] = "Player 1 to cell $cell";
        
        // Check for win after player move
        if (checkWin($_SESSION['board'], 'x')) {
            $_SESSION['player1_wins']++;
            if ($_SESSION['player1_wins'] >= 3) {
                $_SESSION['game_state'] = 'Player 1 wins the game!';
                return;
            } else {
                $_SESSION['game_state'] = 'Player 1 wins this round!';
                return;
            }
        }

        if (!in_array('1', $_SESSION['board'])) {
            $_SESSION['game_state'] = 'Draw';
            return;
        }

        computerMove(); // After player's move, it's computer's turn
    }
}

// Handle the computer's move
function computerMove() {
    if ($_SESSION['game_state'] !== 'playing') return;

    $cell = findBestMove();
    if ($cell !== null) {
        $_SESSION['board'][$cell] = 'o'; // Computer move
        $_SESSION['moves'][] = "Computer to cell $cell";
        
        // Check for win after computer move
        if (checkWin($_SESSION['board'], 'o')) {
            $_SESSION['player2_wins']++;
            if ($_SESSION['player2_wins'] >= 3) {
                $_SESSION['game_state'] = 'Computer wins the game!';
                return;
            } else {
                $_SESSION['game_state'] = 'Computer wins this round!';
                return;
            }
        }
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cell'])) {
        playerMove($_POST['cell']);
    }
    if (isset($_POST['start_game'])) {
        initGame(); // Start a new game
    }
}

// Initialize game if not already started
if (!isset($_SESSION['board'])) {
    initGame();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <style>
        .cell {
            width: 100px; 
            height: 100px; 
            text-align: center; 
            vertical-align: middle; 
            font-size: 36px; 
            cursor: pointer; 
        }
        .cell:hover { 
            background-color: #f8f9fa; 
        }
        .player1 { 
            background-color: #add8e6; /* Pastel Blue */ 
        }
        .player2 { 
            background-color: #f08080; /* Pastel Red */ 
        }
        .empty { 
            background-color: #ffffff; /* White for empty cells */ 
        }
        table { 
            border-collapse: collapse; 
            margin: 20px auto; 
        }
    </style>
</head>
<body>
    <h1 class="text-center mb-4">Tic Tac Toe</h1>
    
    <form method="post" class="text-center">
        <?php printBoard($_SESSION['board']); ?>

        <input type="hidden" name="cell" id="cell_number">
        <p><?= $_SESSION['game_state'] ?></p>
        <button type="submit" name="start_game" class="btn btn-primary mt-3">Start New Game</button>
    </form>

    <script>
        function makeMove(cellNumber) {
            document.getElementById('cell_number').value = cellNumber;
            document.forms[0].submit();
        }
    </script>
</body>
</html>
